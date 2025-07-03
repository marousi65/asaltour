function checkEmail(myForm) {
if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.email.value)){
		if (myForm.pass.value == "") {
			alert("کلمه عبور خود را وارد کنید")
			myForm.pass.focus()
			return false
		}
		return true
}
alert("آدرس ایمیل مورد قبول نیست")
return (false)

}