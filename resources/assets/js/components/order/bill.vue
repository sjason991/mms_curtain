<template>
    <div>
        <Row>
            <Col span="8" offset="10">
                <span style="font-size: 20px;font-weight">客户：{{this.name}} </span>
            </Col>
        </Row>
        <br>
        <Row>
            <Col span="8" offset="10">
                <span style="font-size: 20px;font-weight">手机：{{this.phone}}</span>
            </Col>
        </Row>
        <br>
        <Row>
            <Col span="8" offset="10">
                <span style="font-size: 20px;font-weight">订单号：{{this.ordid}}</span>
            </Col>
        </Row>
        <br>
        <Row>
            <Col span="8" offset="10">
                <span style="font-size: 20px;font-weight">总金额：{{this.totprice}} 元</span>
            </Col>
        </Row>
        <br>
        <br>
        <Row>
            <Button type="warning" @click="payall" long v-show="status">== 全额 付款 ==</Button>
            <br><br>
            <Button type="warning" @click="paydown" long v-show="status">== 支付 定金 ==</Button>
        </Row>
        <Modal
                v-model="modal1"
                title="选择付款方式"
                @on-ok="ok"
                @on-cancel="cancel"
                ok-text="确认到账">
            <div style="text-align: center">
                <img :src='zfb_img' alt="" width="200px">
                <img :src='wx_img' alt="" width="200px">
            </div>
        </Modal>
        <Modal
                v-model="modal2"
                title="预付定金"
                @on-ok="ok2"
                @on-cancel="cancel"
                ok-text="确定定金">
            <div style="text-align: center">
                <b style="font-size:20px">总金额：{{totprice}} 元</b>
                <br>
                <br>
                <b>定金：</b><Input v-model="downprice" placeholder="输入定金..." style="width: 300px"></Input>
            </div>
        </Modal>
    </div>
</template>
<script>
    export default {
        props:['ord_id'],
        data() {
            return {
                wx_img: 'http://'+window.location.host+'/payimg/wx.jpg',
                zfb_img: 'http://'+window.location.host+'/payimg/zfb.jpg',
                name: '',
                phone: '',
                ordid: 'WQ'+this.ord_id,
                totprice: '',
                modal1: false,
                modal2: false,
                status:'',
                downprice: '',
                payway: 0,
            }
        },
        mounted() {
            this.datainit()
        },
        methods: {
            datainit(){
                axios({
                    method: 'post',
                    url: '/api/orderinfobybill',
                    data: {ord: this.ord_id},
                }).then(res=>{
                    this.status = (res.data.data)['status'] == 1 ? true : false;
                    this.name = (res.data.data)['name'];
                    this.phone = (res.data.data)['phone'];
                    this.totprice = (res.data.data)['total_price'];
                });
            },

            payall() {
                this.modal1 = true;
            },

            paydown() {
                this.modal2 = true;

            },

            ok () {
                axios({
                    method: 'post',
                    url: '/api/pay',
                    data: {
                        id: this.ord_id,
                        down_price: this.downprice,
                        total_price: this.totprice,
                        payway: this.payway
                    }
                }).then( res => {
                    if(res.data.code == 200){
                        this.$Notice.success({
                            title: res.data.data,
                        });
                        window.location.href='/order';
                    }else{
                        this.$Message.error(res.data.data);
                    }
                });
            },
            cancel () {
            },

            ok2 () {
                if(eval(this.downprice) > eval(this.totprice)){
                    this.$Notice.error({
                        title: '定金大于金额了哦！',
                    });
                }else if(this.downprice == ''){
                    this.$Notice.error({
                        title: '请输入定金！',
                    });
                }else{
                    this.payway = 1;
                    this.modal1 = true;
                }
            },
        }

    }
</script>



