<template>
    <div>
        <Row>
            <Col span="6" offset="22">
                <Button type="success" @click="modal = true">新增</Button>
                <Modal
                        v-model="modal"
                        title="请输入类名"
                        @on-ok="ok"
                        @on-cancel="cancel">
                    <input type="text" v-model="value1" class="ivu-input" >
                </Modal>
            </Col>
        </Row>
        <br>
        <Row>
            <Table border :columns="columns" :data="data">
                <p>
                    Name: {{ value }}
                </p>
                <Button @click="success(true)">Success</Button>
                <Button @click="error(true)">Error</Button>
            </Table>
        </Row>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                columns: [
                    {
                        title: 'ID',
                        key: 'id',
                    },
                    {
                        title: '类名',
                        key: 'gcate_name'
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 150,
                        align: 'center',
                        render: (h, params) => {
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'primary',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.handleRender(params.index)
                                        }
                                    }
                                }, '修改'),
                                h('Button', {
                                    props: {
                                        type: 'error',
                                        size: 'small'
                                    },
                                    on: {
                                        click: () => {
                                            this.handleDel(params.index)
                                        }
                                    }
                                }, '删除')
                            ]);
                        }
                    }
                ],
                data: [],
                value: '',
                modal: false,
                value1: '',
            }
        },
        mounted() {
            this.getGoodscate();
        },
        methods: {
            getGoodscate() {
                axios({
                    method: 'get',
                    url: '/api/getgoodscate'
                }).then(res => {
                    if(res.data.code == 200)
                        this.data = res.data.data;
                });
            },
            handleRender (index) {
                var _this = this
                this.$Modal.confirm({
                    render: (h) => {
                        return h('div',[
                            h('h5','将 【 '+this.data[index].gcate_name+' 】 改为'),
                            h('Input', {
                                props: {
                                    value: this.value,
                                    autofocus: true,
                                },
                                style:{
                                    width: '200px',
                                    margin: '15px auto'
                                },
                                on: {
                                    input: (val) => {
                                        this.value = val
                                    }
                                },
                            })
                        ])
                    },
                    onOk() {
                        axios({
                            method: 'post',
                            url: '/api/updategoodscate',
                            data: {
                                id: _this.data[index].id,
                                cate: _this.value,
                            },
                        }).then(res => {
                            if(res.data.code == 404){
                                this.$Notice.error({
                                    title: res.data.data,
                                });
                            }else{
                                _this.data[index].gcate_name = res.data.data;
                            }
                        });
                    }
                })
            },
            handleDel (index) {
                var _this = this
                this.$Modal.confirm({
                    render: (h) => {
                        return h('div',[
                            h('h5','确认删除【'+this.data[index].gcate_name+'】分类？(该分类下的型号会一并删除哦！)'),
                        ])
                    },
                    onOk() {
                        axios({
                            method: 'post',
                            url: '/api/delgoodscate',
                            data: {
                                id: _this.data[index].id,
                            },
                        }).then(res => {
                            if(res.data.code == 200){
                                this.$Notice.success({
                                    title: res.data.data,
                                });
                                _this.getGoodscate();
                            }else{
                                this.$Notice.error({
                                    title: '删除失败！',
                                });
                            }
                        });
                    }
                })
            },
            ok () {
                axios({
                    method: 'post',
                    url: '/api/addgoodscate',
                    data: {
                        cate: this.value1,
                    },
                }).then(res => {
                    if(res.data.code == 200){
                        this.$Notice.success({
                            title: res.data.data,
                        });
                        this.getGoodscate();
                    }else{
                        this.$Notice.error({
                            title: res.data.data,
                        });
                    }
                });
            },
            cancel () {
            }
        }
    }
</script>
