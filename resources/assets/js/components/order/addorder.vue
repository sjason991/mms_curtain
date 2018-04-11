<template>
    <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="80">
        <FormItem label="客户姓名" prop="name">
            <Input v-model="formValidate.name" placeholder=""></Input>
        </FormItem>
        <FormItem label="联系电话" prop="phone">
            <Input v-model="formValidate.phone" placeholder=""></Input>
        </FormItem>
        <FormItem label="客户地址" prop="address">
            <Input v-model="formValidate.address" placeholder=""></Input>
        </FormItem>
        <Row style="background:#eee;padding:20px;">
            <Row>
                <FormItem label="清单详情"></FormItem>
                <FormItem style="height: 10px">
                    <Row :gutter="15">
                        <Col span="3">商品名称</Col>
                        <Col span="3">型号/规格</Col>
                        <Col span="3">单价</Col>
                        <Col span="3">数量</Col>
                        <Col span="2">小计</Col>
                        <Col span="3">房间</Col>
                    </Row>
                </FormItem>
                <FormItem
                        v-for="(item,index) in formValidate.items"
                        v-if="item.status"
                        :key="index"
                        :prop="'items.' + index + '.value'">
                    <Row>
                        <Col span="3">
                            <Select v-model="item.cate" placeholder="选择商品" @on-change="chacate(index)" :disabled=!!sta>
                                <Option v-for="item in catelist" :value="item.id" :key="item.id">{{ item.gcate_name }}</Option>
                            </Select>
                        </Col>
                        <Col span="3">
                            <Select v-model="item.model_value" filterable @on-change="chamodel(index)" :disabled=!!sta>
                                <Option v-for="item in item.model_data" :value="item.id" :key="item.id">{{ item.gmodel_name }}</Option>
                            </Select>
                        </Col>
                        <Col span="3">
                            <Input type="text" v-model="item.price" placeholder="输入单价" @on-change="countchange(index)" :disabled=!!sta></Input>
                        </Col>
                        <Col span="3">
                        <Input type="text" v-model="item.count" placeholder="输入数量" @on-change="countchange(index)" :disabled=!!sta></Input>
                        </Col>
                        <Col span="2">
                            <Input type="text" v-model="item.sum" placeholder="" readonly></Input>
                        </Col>
                        <Col span="3">
                            <Select v-model="item.room" :disabled=!!sta>
                                <Option value="beijing">New York</Option>
                                <Option value="shanghai">London</Option>
                                <Option value="shenzhen">Sydney</Option>
                                <Option value="shenzhen">Sydney</Option>
                                <Option value="shenzhen">Sydney</Option>
                                <Option value="shenzhen">Sydney</Option>
                            </Select>
                        </Col>
                        <Col span="4" offset="1">
                            <Button type="ghost" @click="handleRemove(index)" v-if="!sta">删除</Button>
                        </Col>
                    </Row>
                </FormItem>
                <FormItem>
                    <Row>
                        <Col span="17">
                        <Button type="dashed" long @click="handleAdd()" icon="plus-round" v-if="!sta">添加</Button>
                        </Col>
                    </Row>
                </FormItem>
            </Row>
            <Row :gutter="15">
                <Col span="3" offset="15">
                    <Card shadow>
                        <p slot="title">总金额</p>
                        <p>{{formValidate.tolprice}} 元</p>
                    </Card>
                </Col>
            </Row>
        </Row>
        <FormItem label="备注" prop="remark"  style="padding:20px;">
            <Input v-model="formValidate.remark" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter something..."></Input>
        </FormItem>
        <FormItem>
            <Button type="primary" @click="handleSubmit('formValidate')" v-show="!this.ord">提交</Button>
            <Button type="primary" @click="handleEdit('formValidate')" v-show="this.ord">保存</Button>
            <Button type="ghost" @click="handleReset('formValidate')" style="margin-left: 8px">重置</Button>
        </FormItem>
    </Form>
</template>
<script>
    export default {
        props:['ord','sta'],
        data () {
            return {
                catelist: [],
                index: 0,
                formValidate: {
                    name: '',
                    phone: '',
                    address: '',
                    tolprice: 0,
                    remark: '',
                    items: [
                        {
                            cate: '',
                            model_value: '',
                            count: '',
                            price: '',
                            sum: '',
                            model_data: [],
                            room: '',
                            index: 0,
                            status: 1
                        },
                    ]
                },
                ruleValidate: {
                    name: [
                        { required: true, message: '请输入客户姓名！', trigger: 'blur' }
                    ],
                    phone: [
                        { required: true, message: '请输入客户电话！', trigger: 'blur'},
                    ],
                    address: [
                        { required: true, message: '请输入客户地址！', trigger: 'blur' }
                    ],
                    remark: [
                        { type: 'string', trigger: 'blur' }
                    ]
                },
                //确认订单页
                modal1: false,
                columns: [
                    {
                        title: '产品',
                        key: 'cate'
                    },
                    {
                        title: '型号/规格',
                        key: 'model_value'
                    },
                    {
                        title: '单价（米/平方）',
                        key: 'price'
                    },
                    {
                        title: '数量（米/平方）',
                        key: 'count'
                    },
                    {
                        title: '小计',
                        key: 'sum'
                    },
                    {
                        title: '房间',
                        key: 'room'
                    },
                ],
                goodslist: [],
            }
        },
        created() {
            this.getGoodscate();
            this.geteditdata();
        },
        methods: {
            getGoodscate() {
                axios({
                    method: 'get',
                    url: '/api/getgoodscate'
                }).then(res => {
                    if(res.data.code == 200){
                        this.catelist = res.data.data;
                    }else{
                        this.$Notice.warning({
                            title: res.data.data,
                        });
                    }
                });
            },
            geteditdata() {
                if(this.ord != null){
                    axios({
                        method: 'get',
                        url:'/api/order/'+this.ord+'/edit',
                    }).then(res=>{
                        if(res.data.code == 200){
                            let datas = res.data.data;
                            this.formValidate.name = datas.user.name;
                            this.formValidate.phone = datas.user.phone;
                            this.formValidate.address = datas.order.address;
                            this.formValidate.remark = datas.order.remark;
                            this.formValidate.tolprice = datas.order.total_price;
                            var _this = this;
                            _this.formValidate.items.splice(0);
                            $.each(datas.order_list,function(k,v){
                                let data = {};
                                axios({
                                    method: 'post',
                                    url: '/api/modellist',
                                    data: {id: v.cate_id},
                                }).then(res => {
                                    if(res.data.code == 200){
                                        data['model_data'] = res.data.data;
                                        data['cate'] = v.cate_id;
                                        data['model_value'] = v.model_id;
                                        data['count'] = v.goods_num;
                                        data['price'] = v.goods_price;
                                        data['sum'] = v.subtotal;
                                        data['room'] = v.room_name;
                                        data['index'] = k;
                                        data['status'] = 1;
                                        _this.formValidate.items.push((data));
                                    }else{
                                        this.$Notice.warning({
                                            title: res.data.data,
                                        });
                                    }
                                });
                            });
                        }
                    })
                }
            },

            chacate(index) {
                axios({
                    method: 'post',
                    url: '/api/modellist',
                    data: {id: this.formValidate.items[index].cate},
                }).then(res => {
                    if(res.data.code == 200){
                        this.formValidate.items[index].model_data = res.data.data;
                    }else{
                        this.$Notice.warning({
                            title: res.data.data,
                        });
                    }
                });
            },
            chamodel(index) {
                var id = this.formValidate.items[index].model_value;
                var price = this.formValidate.items[index].price;
                $.each(this.formValidate.items[index].model_data,function(name,value) {
                    if(value.id == id){
                        price = value.gmodel_price;
                    }
                });
                this.formValidate.items[index].price = price;
                this.countchange(index);
            },
            countchange(index) {
                this.formValidate.items[index].sum = (this.formValidate.items[index].price * this.formValidate.items[index].count).toFixed(2);
                //总价
                var all = 0;
                $.each(this.formValidate.items,function(name,value) {
                    if(value.status == 1){
                        all = Number(value.sum) + Number(all);
                    }
                });
                this.formValidate.tolprice = all.toFixed(2);
            },

            //提交
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Spin.show({
                            render: (h) => {
                                return h('div', [
                                    h('Icon', {
                                        'class': 'demo-spin-icon-load',
                                        props: {
                                            type: 'load-c',
                                            size: 30
                                        }
                                    }),
                                    h('div', 'Loading')
                                ])
                            }
                        });
                        axios({
                            method: "post",
                            url: '/api/order',
                            data: {info: this.formValidate}
                        }).then(res=>{
                            if(res.data.code == 200){
                                setTimeout(() => {
                                    this.$Spin.hide();
                                }, 3000);
                                window.location.href='/showbill/'+res.data.data;
                            }else{
                                this.$Spin.hide();
                                this.$Notice.warning({
                                    title: res.data.data,
                                });
                            }
                        });
                    } else {

                    }
                })
            },
            //编辑
            handleEdit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Spin.show({
                            render: (h) => {
                                return h('div', [
                                    h('Icon', {
                                        'class': 'demo-spin-icon-load',
                                        props: {
                                            type: 'load-c',
                                            size: 30
                                        }
                                    }),
                                    h('div', 'Loading')
                                ])
                            }
                        });
                        axios({
                            method: "put",
                            url: '/api/order/'+this.ord,
                            data: {info: this.formValidate}
                        }).then(res=>{
                            if(res.data.code == 200){
                                setTimeout(() => {
                                    this.$Spin.hide();
                                }, 3000);
                                console.log(res.data.data['st']);
                                if(res.data.data['st']==1){
                                    window.location.href='/showbill/'+res.data.data['id'];
                                }else{
                                    window.location.href='/order';
                                }

                            }else{
                                this.$Spin.hide();
                                this.$Notice.warning({
                                    title: res.data.data,
                                });
                            }
                        });
                    } else {

                    }
                })
            },

            handleReset (name) {
                this.$refs[name].resetFields();
            },

            handleAdd () {
                this.index++;
                this.formValidate.items.push({
                    model_value: '',
                    count: '',
                    price: '',
                    sum: '',
                    model_data: [],
                    room: '',
                    index: this.index,
                    status: 1
                });
            },
            handleRemove (index) {
                this.formValidate.items[index].status = 0;
                this.countchange(index);
            },
        }
    }
</script>
