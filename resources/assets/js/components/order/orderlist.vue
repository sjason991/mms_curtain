<template>
    <div>
        <Row>
            <Table border :columns="columns" :data="listdata"></Table>
        </Row>
        <br>
        <Row>
            <Col offset="5">
                <Page :total="page" @on-change="pagefrom" show-total :page-size="pagesize"></Page>
            </Col>
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
                        width: 60
                    },
                    {
                        title: '姓名',
                        key: 'name',

                    },
                    {
                        title: '电话',
                        key: 'phone',
                        width: 120,
                    },
                    {
                        title: '地址',
                        key: 'address',
                        width: 250,
                    },
                    {
                        title: '总金额',
                        key: 'total_price',

                    },
                    {
                        title: '状态',
                        key: 'status',
                        width: 125,
                        render: (h,params) => {
                            switch(params.row.status)
                            {
                                case 1:
                                    return h('p','未付款');
                                    break;
                                case 2:
                                    return h('b','已收定金-未制作');
                                    break;
                                case 3:
                                    return h('b','已全款-未制作');
                                    break;
                                case 4:
                                    return h('p','已制作-待安装');
                                    break;
                                case 5:
                                    return h('p','已安装-未收尾款');
                                    break;
                            }
                        }
                    },
                    {
                        title: '日期',
                        key: 'created_at',
                        width: 100
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 180,
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
                                            this.edit(params.index)
                                        }
                                    }
                                }, '编辑'),
                                h('Button', {
                                    props: {
                                        type: 'success',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
//                                        click: () => {
//                                            this.remove(params.index)
//                                        }
                                    }
                                }, '进度'),
                                h('Button', {
                                    props: {
                                        type: 'error',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.delete(params.index)
                                        }
                                    }
                                }, '删除')
                            ]);
                        }
                    }
                ],
                page: 0,
                pagesize: 10,
                alldata: [],
                listdata: [],

                //editmdoel
            }
        },
        mounted() {
            this.getdata();
        },
        methods: {
            getdata() {
                axios({
                    method:'get',
                    url:'/api/order',
                }).then(res=>{
                    this.page = res.data.data.length;
                    this.alldata = res.data.data;
                    this.listdata = res.data.data.slice(0,this.pagesize)
                });
            },
            pagefrom(page) {
                var _start = ( page - 1 ) * this.pagesize;
                var _end = page * this.pagesize;
                this.listdata = this.alldata.slice(_start,_end);
            },
            edit (index) {
                window.location.href = '/order/'+this.alldata[index].id+'/edit';
            },
            delete (index) {

                //
            }
        }
    }
</script>
