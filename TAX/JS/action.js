/*javascript document*/
function login_action(){
	var x = document.getElementById("loginButton");
	var y = document.getElementById("loginInput");
	if(y.style.display == "none"){
		x.innerHTML = "取消登陆";
		y.style.display = "";
	}
	else{
		x.innerHTML = "管理员登陆";
		y.style.display = "none";
	}
}
function validateLogin(){
	var x = document.forms["loginInput"]["username"].value;
	var y = document.forms["loginInput"]["password"].value;
	var patt = /^([a-z]|[A-Z]|[0-9])+$/;
	if(x==null || x==""){
		alert("用户名不能为空");
		return false;
		
	}
	if(y==null || y==""){
		alert("密码不能为空");
		return false;
		
	}
	if(!patt.test(x)){
		alert("用户名只允许出现数字和英文字符");
		return false;
	
	}
	if(!patt.test(y)){
	alert("密码只允许出现数字和英文字符");
		return false;
		
	}
}
function open_excel(){
	var x = document.getElementById("excelShade");
	if(x.style.display == "none"){
		x.style.display = "";
	}
}
function hidden_excel(){
	var x = document.getElementById('excelShade');
	if(x.style.display == ""){
		x.style.display = "none";
	}
}
function open_trade(){
	var x = document.getElementById("tradeShade");
	if(x.style.display == "none"){
		x.style.display = "";
	}
}
function hidden_trade(){
	var x = document.getElementById("tradeShade");
	if(x.style.display == ""){
		x.style.display = "none";
	}
}
function open_field(){
	var x = document.getElementById("fieldShade");
	if(x.style.display == "none"){
		x.style.display = "";
	}
}
function hidden_field(){
	var x = document.getElementById("fieldShade");
	if(x.style.display == ""){
		x.style.display = "none";
	}
}
function unfold_title(element){
	var x = document.getElementsByClassName(element.id);
	if(element.innerHTML == '-'){
		element.innerHTML = "+";
		for(var i=0;i<x.length;i++){
			x[i].style.display = "none";
		}	
	}
	else{
		element.innerHTML = '-';
		for(var i=0;i<x.length;i++){
			x[i].style.display = "";
		}
	}
}
function rename_industry(){
	var x;
	var newName=prompt("请输入新的行业名称","");
	if (newName!=null && newName!=""){
	    x=newName;
	    var y=document.getElementsByName("inNewName");
		for(i=0;i<y.length;i++){
			y[i].value=x;
		}
		return true;
}
	else{
		return false;
	}
}
function delete_industry(){
	var r=confirm("确定删除该行业吗？删除后该行业所有数据将全部消失!");
	if (r==true){
		return true;
	}
	else{
		return false;
	}
}
function truncate_industry(){
	var r=confirm("确定清空该行业所有内容吗？清空内容后该行业所有数据将全部消失!");
	if (r==true){
		return true;
	}
	else{
		return false;
	}
}
function rename_field(){
	var patt = /^[0-9]+$/;
	var x;
	var newName=prompt("请输入新的字段名称","");
	if (patt.test(newName)){
	alert('字段名不能只为数字');
	return false;
	}
	else if (newName!=null && newName!=""){
	    x=newName;
	    var y=document.getElementsByName("fiNewName");
		for(i=0;i<y.length;i++){
			y[i].value=x;
		}
		return true;
}
	else{
		return false;
	}
}
function delete_field(){
	var r=confirm("确定删除该字段吗？删除后该字段所有数据将全部消失!");
	if (r==true){
		return true;
	}
	else{
		return false;
	}
}
function field_width(){
	var x;
	var newName=prompt("请输入宽度（允许输入绝对宽度如：100px或百分比宽度如:10%）","");
	if (newName!=null && newName!=""){
	    x=newName;
	    var y=document.getElementsByName("chfieldWidth");
		for(i=0;i<y.length;i++){
			y[i].value=x;
		}
		return true;
}
	else{
		return false;
	}
}
function revise_content(){
	var r=confirm("确定要修改吗？");
	if (r==true){
		return true;
	}
	else{
		return false;
	}
}
function delete_row(){
	var r=confirm("确定删除该行吗？删除后该行所有数据将全部消失!");
	if (r==true){
		return true;
	}
	else{
		return false;
	}
}
function new_user(){
	var x = document.forms["addUser"]["user"].value;
	var y = document.forms["addUser"]["pwd"].value;
	var z = document.forms["addUser"]["confirm"].value;
	var patt = /^([a-z]|[A-Z]|[0-9])+$/;
	if(x==null || x==""){
		alert("用户名不能为空");
		return false;
		
	}
	if(y==null || y==""){
		alert("密码不能为空");
		return false;
		
	}
	if(!patt.test(x)){
		alert("用户名只允许出现数字和英文字符");
		return false;
	
	}
	if(!patt.test(y)){
	alert("密码只允许出现数字和英文字符");
		return false;
		
	}
	if(y != z){
		alert("两次输入的密码不同!");
		return false;
		
	}
}
function drop_user(){
	var r=confirm("确定删除该用户吗？");
	if (r==true){
		return true;
	}
	else{
		return false;
	}
}
function confirm_des(){
	var r=confirm("确定修改描述吗？");
	if (r==true){
		return true;
	}
	else{
		return false;
	}
}