<template>
    <Form ref="formInline" :model="formInline" :rules="ruleInline">
        <FormItem prop="phone">
            <Input type="text" v-model="formInline.phone" placeholder="手机号">
            <Icon type="ios-person-outline" slot="prepend"></Icon>
            </Input>
        </FormItem>
        <FormItem>
            <Button type="primary" @click="handleSubmit('formInline')">登录</Button>
        </FormItem>
    </Form>
</template>
<script>
    export default {
        data () {
            return {
                formInline: {
                    phone: '',
                },
                ruleInline: {
                    phone: [
                        { required: true, message: '请输入手机号！', trigger: 'blur' },
                        { type: 'string', min:11, max: 11, message: '输入正确的手机号！', trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        axios({
                            method: 'post',
                            url: '/login',
                            data: {
                                phone: this.formInline.phone,
                                password:'123123',
                            },
                        }).then(res => {
                            if(res.data == 0){
                                this.$Notice.error({
                                    title: '登陆失败！请核对手机号！',
                                });
                            }else{
                                location.reload()
                            }
                        });
                    }
                })
            }
        }
    }
</script>
