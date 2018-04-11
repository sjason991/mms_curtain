<template>
    <div>
        <Row>
            <Col offset="">
                <span class="h4">请选择商品分类：</span>
                <Select v-model="modelsel" style="width:200px" @on-change="chamodel">
                    <Option v-for="item in modelList" :value="item.id" :key="item.id">{{ item.gcate_name }}</Option>
                </Select>
            </Col>
            <Col span="6" offset="22">
                <Button type="success" @click="addbtn">新增</Button>
                <Modal
                        v-model="modal"
                        title="添加型号"
                        @on-ok="ok"
                        @on-cancel="cancel">
                    <div style="text-align:center"><span>型号规格：</span><input type="text" v-model="value1" class="ivu-input" style="width: 200px;margin:10px auto"></div>
                    <div style="text-align:center"><span>单位价格：</span><input type="text" v-model="value4" class="ivu-input" style="width: 200px;margin:10px auto"></div>
                </Modal>
            </Col>
        </Row>
        <br>
        <Row>
            <Table border :columns="columns" :data="data" no-data-text="请选择商品类型！">
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
                        title: '型号/规格',
                        key: 'gmodel_name'
                    },
                    {
                        title: '价格',
                        key: 'gmodel_price'
                    },
                    {
                        title: '分类',
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
                value2: '',
                value4: '',
                modal: false,
                value1: '',
                modelList: [],
                modelsel: '',
            }
        },
        created() {
            this.getGoodscate();
        },
        methods: {
            getGoodscate() {
                axios({
                    method: 'get',
                    url: '/api/getgoodscate'
                }).then(res => {
                    if(res.data.code == 200){
                        this.modelList = res.data.data;
                    }else{
                        this.$Notice.warning({
                            title: res.data.data,
                        });
                    }
                });
            },
            chamodel() {
                axios({
                    method: 'post',
                    url: '/api/modellist',
                    data: {id: this.modelsel},
                }).then(res => {
                    if(res.data.code == 200){
                        this.data = res.data.data;
                    }else{
                        this.data = [];
                        this.$Notice.warning({
                            title: res.data.data,
                        });
                    }
                });
            },
            handleRender (index) {
                var _this = this
                this.$Modal.confirm({
                    render: (h) => {
                        return h('div',[
                            h('h5','修改 【 '+this.data[index].gmodel_name+' 】 '),
                            h('div',[
                                h('span','型号规格：'),
                                h('Input', {
                                    props: {
                                        value: this.value,
                                        autofocus: true,
                                    },
                                    style:{
                                        width: '200px',
                                        margin: '10px auto'
                                    },
                                    on: {
                                        input: (val) => {
                                            this.value = val
                                        }
                                    },
                                }),
                            ]),
                            h('div',[
                                h('span','单位价格：'),
                                h('Input', {
                                    props: {
                                        value: this.value2,
                                        autofocus: true,
                                    },
                                    style:{
                                        width: '200px',
                                    },
                                    on: {
                                        input: (val) => {
                                            this.value2 = val
                                        }
                                    },
                                })
                            ]),
                        ])
                    },
                    onOk() {
                        axios({
                            method: 'put',
                            url: '/api/goodsmodel/{}',
                            data: {
                                id: _this.data[index].id,
                                model: _this.value,
                                price: _this.value2,
                            },
                        }).then(res => {
                            if(res.data.code == 404){
                                this.$Notice.error({
                                    title: res.data.data,
                                });
                            }else{
                                _this.data[index].gmodel_name = res.data.data[0];
                                _this.data[index].gmodel_price = res.data.data[1];
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
                            h('h5','确认删除【'+this.data[index].gmodel_name+'】？'),
                        ])
                    },
                    onOk() {
                        axios({
                            method: 'delete',
                            url: '/api/goodsmodel/{}',
                            data: {
                                id: _this.data[index].id,
                            },
                        }).then(res => {
                            if(res.data.code == 200){
                                this.$Notice.success({
                                    title: res.data.data,
                                });
                                _this.chamodel();
                            }else{
                                this.$Notice.error({
                                    title: res.data.data,
                                });
                            }
                        });
                    }
                })
            },
            addbtn() {
                if(this.modelsel == ''){
                    this.$Notice.warning({
                        title: '请先选择商品类型！',
                    });
                }else{
                    this.modal = true;
                }
            },
            ok () {
                axios({
                    method: 'post',
                    url: '/api/goodsmodel',
                    data: {
                        model: this.value1,
                        price: this.value4,
                        cate_id: this.modelsel,
                    },
                }).then(res => {
                    if(res.data.code == 200){
                        this.$Notice.success({
                            title: res.data.data,
                        });
                        this.chamodel();
                    }else{
                        this.$Notice.error({
                            title: res.data.data,
                        });
                    }
                });
            },
            cancel () {
            },
        }
    }
</script>
