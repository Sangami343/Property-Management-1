 <?php require_once("4WPMConfiguration.php"); ?>
<?php require_once("4WPMMaintenance.php"); ?>
<?php require_once("sendMail.php");?>
<?php 
$ajax=new jqSajax(0,1,1);
$ajax->export("SelectCompanyByName","SelectUserByLogin","recaptcha_check_answer","SetSubmitSession","ActDeactivateUserAccount" );
$ajax->processClientReq();
?>
<script src="Javascripts/cleave.js"></script>
<script src="Javascripts/cleave-phone.i18n.js"></script> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo _("4W Property Management"); ?></title>
<?php require_once("4WPMIncludes.php"); ?>
<?php require_once("CheckLandlord.php"); ?>       
<?php require_once("LandlordChild.php"); ?>
<script language="javascript" type="text/javascript">
<?php $ajax->showJs(); ?> 
function onKeyDown() {
  var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();
 
  if (event.ctrlKey && (pressedKey == "c" || 
                        pressedKey == "v" || pressedKey == "x")) {
    event.returnValue = false;
  }
  
} // onKeyDown

function fRightclick() 
{ 
    if (event.button==2) 
  { 
  window.parent.AlertMsg("Right click is not allowed for password fields!"); 
  return; 
  } 
 
}
</script>
<script type="text/javascript">

$(document).ready( function() {
    $('#txtFltrSubmitFromDate').datepicker();
    $('#txtFltrSubmitToDate').datepicker( );
});
$(document).ready(function(){  
    $("ul.sf-menu").superfish({  
        animation: {height:'show'},  
        delay: 1  
    });  
});  
function fOffFocusOutFormat(userid,count,type){//alert("fOffFocusOutFormat : userid : "+userid+" count : "+count+" type : "+type);
        //txtUser1Phone1
	    //alert("add");
		var Phnumber=document.getElementById('txtUser'+userid+'Phone'+count).value;
		var CountryDropdown=document.getElementById('PhoneDropdown'+userid+'Phone'+count).value;	
		var e = document.getElementById('PhoneDropdown'+userid+'Phone'+count);
		var strUser = e.options[e.selectedIndex].text;
		var code=strUser.replace(/[^a-zA-Z0-9 ]/g, "");
		var codesplit1=strUser.split('(');
		var codesplit2=codesplit1[1].split(')');	
		var CountryCodeArr = {US:"+1",GB:"+44",SG:"+65",TH:"+66",IN:"+91",CA:"+1"};
		var CountryCode=CountryCodeArr[CountryDropdown];
		if((Phnumber.substring(0,1)!="+") && (Phnumber.substring(0,1)!="1")){
			if((CountryDropdown=="US")||(CountryDropdown=="CA")) document.getElementById('txtUser'+userid+'Phone'+count).value=codesplit2[0]+" "+Phnumber;
			else document.getElementById('txtUser'+userid+'Phone'+count).value=codesplit2[0];
		}else if(Phnumber.substring(0,1)=="1"){
			if((CountryDropdown=="US")||(CountryDropdown=="CA")) document.getElementById('txtUser'+userid+'Phone'+count).value="+"+Phnumber;
			else document.getElementById('txtUser'+userid+'Phone'+count).value=codesplit2[0];
		}
		
		Phnumber=document.getElementById('txtUser'+userid+'Phone'+count).value;
		var spacecnt=Phnumber.split(" ").length-1;
		//alert("CountryDropdown : "+CountryDropdown);
		if(((CountryDropdown=="US")||(CountryDropdown=="CA"))&&(spacecnt>1)){
			var Phnumbersplit=Phnumber.split(" ");				
			Phnumber=Phnumbersplit[0]+" "+Phnumbersplit[1]+"-"+Phnumbersplit[2]+"-"+Phnumbersplit[3];
		}
		document.getElementById('txtUser'+userid+'Phone'+count).value=Phnumber;
		var ChkPhone=fValidatePhone(document.getElementById('txtUser'+userid+'Phone'+count));
		//alert("last");
	//}
		
}

function fCheckLoad(Obj,Evnt)
{
    var KeyNum=""
    var ObjID=Obj.id;
    if (window.event) KeyNum=Evnt.keyCode;
    else if (Evnt.which) KeyNum=Evnt.which;
    if (KeyNum==13) fLoadTable();
}
function fChangePage(Direction)
{
    var PageNumObj=document.getElementById('PageNum');
    if (Direction=="First") PageNumObj.options[0].selected=true;
    if (Direction=="Previous")
    {
        var SelIndex=PageNumObj.selectedIndex;
        var NewIndex=SelIndex-1;
        if(NewIndex<0) NewIndex=0;
        PageNumObj.options[NewIndex].selected=true;
    }
    if (Direction=="Next") 
    {
        var SelIndex=PageNumObj.selectedIndex;
        var NewIndex=SelIndex+1;
        var LastIndex=PageNumObj.options.length-1;
        if(NewIndex>LastIndex) NewIndex=LastIndex;
        PageNumObj.options[NewIndex].selected=true;
    }
    if (Direction=="Last") PageNumObj.options[(PageNumObj.options.length-1)].selected=true;
    fLoadTable();
}
function fLoadTable()
{    
    document.AddUserForm.submit();
}
</script>
<script type="text/javascript">
<?php $ajax->showJs(); ?>

function ExpandCollapse(ExpandDiv)
{
    var headingTags=document.getElementsByTagName("h2");
    for (var i=0; i<headingTags.length; i++)
    {
        var el=headingTags[i];
        if ((el.parentNode.className!="panel")&&( el.parentNode.className!="panelcollapsed")) continue;
        var name = el.firstChild.nodeValue;
        if (ExpandDiv=='All') panelsStatus[name]="true";
        else
        {
            if (ExpandDiv.indexOf(name)!=-1) panelsStatus[name]="true";
            else panelsStatus[name]="false";
        }
    }
    setUpPanels();
}
function fShowAddNewOption(ObjImage,ObjDiv)
{
    if (ObjDiv.style.visibility=='hidden')
    {
        ObjDiv.style.visibility='';
        ObjImage.setAttribute("src", "Images/blueminus.png");
    }
    else
    {
        ObjDiv.style.visibility='hidden';
        ObjImage.setAttribute("src", "Images/blueplus.png");
    }
}
function fAddNewOption(ObjImg,ObjTxt)
{
    var QuestionID=ObjTxt.id.charAt(14);
    var Str=ObjTxt.value;
    var ChkStr=fValidateSize(ObjTxt,'Subject');
    if (ChkStr==0) return;
    var OptExists=0;
    var ObjList=document.getElementById('cmbQuestion1');
    for(i=0;i<ObjList.options.length;i++)
    {
        if(ObjList.options[i].text.toUpperCase()==Str.toUpperCase()) OptExists=1;
    }
    if (OptExists==1)
    {
       ObjImg.click();
       window.parent.AlertMsg("<?php echo _("This question is either invalid or already exists"); ?>");
       return;   
    }
    var UsersCount=document.getElementById('txtUsers').value;
    for (i=1;i<=UsersCount;i++)
    {
        var ObjNewList=document.getElementById('cmbQuestion'+i);
        var optObj=new Option();
        optObj.value=Str;
        optObj.text=Str;
        OptLength=ObjNewList.options.length;
        ObjNewList[OptLength]=optObj;
        if (i==QuestionID) ObjNewList.options[OptLength].selected=true;
    }
    document.getElementById('GeneralQuestionDiv').innerHTML=SyncAjax("MySQLConfiguration.php?GetValues=Questions&QuestionID=&Language=<?php echo $locale; ?>&RandomNumber="+Math.random());
    ObjTxt.value='';
    ObjImg.click();
}
function fConfirmPassword(User)
{
    var Users=User.split('User');
    var UserID=Users[1];
    var Password=document.getElementById('txtPassword'+UserID).value;
    var Obj=document.getElementById('txtConfirmPassword'+UserID);
    var ConfirmPassword=Obj.value;
    if ((ConfirmPassword!=Password) || (ConfirmPassword==""))
    {
        Obj.style.background='#F99';
        return 0;
    }
    else
    {
        Obj.style.background='#9F9';
        return 1;
    }
}
function fCheckUserPhone(Obj,User)
{
    var ChkPhone=fValidateUserPhone(Obj,User);
    if (ChkPhone==0) window.parent.AlertMsg('<?php echo _('Please enter a valid and unique phone number'); ?>');
}
function fValidateUserPhone(Obj,User)
{
    var Users=User.split('User');
    var UserID=Users[1];
    var ValidPhone=1;
    //var ChkPhone=fValidatePattern(Obj,'Phone');
	
	var regex =/^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/;
	var ChkPhone="";
	var ph=Obj.value;
	if (regex.test(ph)) {
        //alert("Valid");// Valid international phone number
		ChkPhone=1;
    } else {
		//alert("Invalid");
		ChkPhone=0;
        // Invalid international phone number
    }
	
    if (ChkPhone==0) ValidPhone=0;
    else
    {
        var PhoneValue=Obj.value;
        var PhoneID=Obj.id;
        var PhoneCount=$('#User'+UserID+'PhoneDiv').children("div").length;
        for (var j=1;j<=PhoneCount;j++) 
        {
            var NewPhoneObj=document.getElementById('txtUser'+UserID+'Phone'+j);
            var NewPhoneValue=NewPhoneObj.value;
            var NewPhoneID=NewPhoneObj.id;
            if (NewPhoneID==PhoneID) continue;
            if (NewPhoneValue==PhoneValue)
            {
                ValidPhone=0;
                break;
            }
        }        
    }
    if (ValidPhone==0)
    {
       Obj.style.background="#F99";
       return 0;
    }
    else
    {
       Obj.style.background="#9F9";
       return 1; 
    }
}
function fcheck() {
 
	fLoadTable();
}
function onchangeFunction(Sel,UserID){
	 //alert("onchangeFunction USER ID "+UserID);
	var PhoneID=$('#User'+UserID+'PhoneDiv').children("div").length;
	var e = document.getElementById('PhoneDropdown'+UserID+'Phone'+PhoneID);
    var strUser = e.options[e.selectedIndex].text;
	var code=strUser.replace(/[^a-zA-Z0-9 ]/g, "");
	var codesplit1=strUser.split('(');
	var codesplit2=codesplit1[1].split(')');	
		
	document.getElementById('txtUser'+UserID+'Phone'+PhoneID).value=codesplit2[0];
		var cleave1 = new Cleave('#txtUser'+UserID+'Phone'+PhoneID, {
		phone:true,
		phoneRegionCode: 'US'
	});
}
function onchangeFunction01(Sel,UserID){
	 //alert("onchangeFunction USER ID "+UserID);
	var PhoneID=$('#User'+UserID+'PhoneDiv').children("div").length;
	alert("PhoneID :  "+PhoneID);
	var e = document.getElementById('MPhoneDropdown'+UserID+'Phone'+PhoneID);
    var strUser = e.options[e.selectedIndex].text;
	var code=strUser.replace(/[^a-zA-Z0-9 ]/g, "");
	var codesplit1=strUser.split('(');
	var codesplit2=codesplit1[1].split(')');	
		
	document.getElementById('modelUser'+UserID+'Phone'+PhoneID).value=codesplit2[0];
		var cleave1 = new Cleave('#modelUser'+UserID+'Phone'+PhoneID, {
		phone:true,
		phoneRegionCode: 'US'
	});
}
 function fAddUserPhone(User,Operation)
{
   var Users=User.split('User');
   var UserID=Users[1];
   var PhoneCount=$('#User'+UserID+'PhoneDiv').children("div").length;
   var ValidPhone=1;
   for (var i=1;i<=PhoneCount;i++)
   {
        var ChkPhone=fValidateUserPhone(document.getElementById('txtUser'+UserID+'Phone'+i),User);
        if (ChkPhone==0) ValidPhone=0;
   }
   if (Operation!='Adjust')
   {
       if (ValidPhone==0)
       {
            window.parent.AlertMsg('<?php echo _('Please enter a valid and unique phone number in user'); ?> '+UserID);
            return;
       }
   }
   PhoneID=PhoneCount+1;
   var ParentDiv=document.getElementById('User'+UserID+'PhoneDiv');
   var ChildDiv=document.createElement('div');
   var divPhoneID='divUser'+UserID+'Phone'+PhoneID;
   ChildDiv.setAttribute('id',divPhoneID);
   NewPhone="<table cellpadding=0 cellspacing=0>\
                <tr>\
					<td nowrap><select class='child' name='PhoneDropdown"+UserID+"Phone"+PhoneID+"' id='PhoneDropdown"+UserID+"Phone"+PhoneID+"' size='1' style='background-color:#9F9;width:50px;' onchange=\"onchangeFunction(this.value,'"+UserID+"');\" onfocus='ChangeBackground(this);' onblur='this.style.background=\"#9F9\";'></select></td>\
					<td nowrap>&nbsp;</td>\
                    <td nowrap><input class='child' size=30 maxlength=20 value='+1' name='txtUser"+UserID+"Phone"+PhoneID+"' type='text' style='background-color:#F99;'  id='txtUser"+UserID+"Phone"+PhoneID+"' onfocusout=\"fOffFocusOutFormat('"+UserID+"','"+PhoneID+"','Add');\" onfocus='ChangeBackground(this);' onblur=\"return fCheckUserPhone(this,'User"+UserID+"');\" autocomplete='off'></td>\
                    <td nowrap>&nbsp;</td>\
                    <td nowrap><select class='child' name='cmbUser"+UserID+"Phone"+PhoneID+"' id='cmbUser"+UserID+"Phone"+PhoneID+"' style='background-color:#9F9;' onblur=\"this.style.background='#9F9';\"  onfocus=\"ChangeBackground(this);\"size='1'></select></td>";
                    if (PhoneCount==0)
                    {
                        NewPhone=NewPhone+"<td nowrap>&nbsp;</td>\
                        <td nowrap><img src='Images/blueplus.png' style='width:20px; height:20px;' onclick=\"fAddUserPhone('User"+UserID+"','New');\"></td>";
                    }
                    NewPhone=NewPhone+"<td nowrap>&nbsp;</td>\
                    <td nowrap><img src='Images/blueminus.png' style='width:22px; height:22px;' onClick=\"fRemoveUserPhone('User"+UserID+"',"+PhoneID+");\"></td>\
                </tr>\
            </table>";
   ChildDiv.innerHTML=NewPhone;
   ParentDiv.appendChild(ChildDiv);
   TypeOptObj=document.getElementById('cmbPhone');
   NewTypeOptObj=document.getElementById('cmbUser'+UserID+'Phone'+PhoneID);
   	var cleave2 = new Cleave('#txtUser'+UserID+'Phone'+PhoneID, {
		phone:true,
		phoneRegionCode: 'US'
	});
   for (i=0;i<TypeOptObj.options.length;i++) 
   {
      var CText=TypeOptObj.options[i].text;
      var CValue=TypeOptObj.options[i].value;
      var OptObj=new Option();
      OptObj.value=CValue;
      OptObj.text=CText;
      var OptLength=NewTypeOptObj.options.length;
      NewTypeOptObj[OptLength]=OptObj;
      if (CValue=='Mobile') NewTypeOptObj.options[OptLength].selected=true;
   }
   PhTypeOptObj=document.getElementById('PhoneDropdown');
   PhNewTypeOptObj=document.getElementById('PhoneDropdown'+UserID+'Phone'+PhoneID);
   for (i=0;i<PhTypeOptObj.options.length;i++) 
   {
      var CText=PhTypeOptObj.options[i].text;
      var CValue=PhTypeOptObj.options[i].value;
	  var splitvar=CText.split("(");
      var OptObj=new Option();
      OptObj.value=CValue;
      OptObj.text=CText;
      var OptLength=PhNewTypeOptObj.options.length;
      PhNewTypeOptObj[OptLength]=OptObj;
      if (CValue=="US") PhNewTypeOptObj.options[OptLength].selected=true;  
   }
}
function fRemoveUserPhone(User,PhoneID)
{
   var Users=User.split('User');
   var UserID=Users[1];
   var PhoneCount=$('#User'+UserID+'PhoneDiv').children("div").length;
   if (PhoneCount==1) return;
   var PhoneList=new Array();
   var Count=0;
   var ParentDiv=document.getElementById('User'+UserID+'PhoneDiv');
   for (i=PhoneID;i<=PhoneCount;i++) 
   {
       var Phone=Trim(document.getElementById('txtUser'+UserID+'Phone'+i).value);
       var PhoneType=document.getElementById('cmbUser'+UserID+'Phone'+i).value;
       var ChildDiv=document.getElementById('divUser'+UserID+'Phone'+i);
       ParentDiv.removeChild(ChildDiv);
       if (i==PhoneID) continue;
       PhoneList[Count]=Phone+"~^~"+PhoneType;
       Count=Count+1;
   }
   var ChildCount=$('#User'+UserID+'PhoneDiv').children("div").length;
   for (i=0;i<PhoneList.length;i++) 
   {
       fAddUserPhone(User,'Adjust');
       var PhoneValues=PhoneList[i].split('~^~');
       document.getElementById('txtUser'+UserID+'Phone'+(ChildCount+i+1)).value=PhoneValues[0];
       var PhoneTypeObj=document.getElementById('cmbUser'+UserID+'Phone'+(ChildCount+i+1));
       for (j=0;j<PhoneTypeObj.options.length;j++)
       {
           if (PhoneTypeObj.options[j].value==PhoneValues[1])
           {
               PhoneTypeObj.options[j].selected=true;
               break;
           }
       }
       var ChkPhone=fValidateUserPhone(document.getElementById('txtUser'+UserID+'Phone'+(ChildCount+i+1)),'User'+UserID);
   } 
}
function fCheckUserEmail(Obj,User)
{
    var Users=User.split('User');
    var UserID=Users[1];
    var ChkEmail=fValidateUserEmail(Obj,User);
    if (ChkEmail==0) window.parent.AlertMsg('<?php echo _('Please enter a valid and unique email in user'); ?> '+UserID);
}
function fValidateUserEmail(Obj,User)
{
    var Users=User.split('User');
    var UserID=Users[1];
    var ValidEmail=1;
    var ChkEmail=fValidatePattern(Obj,'Email');
    if (ChkEmail==0) ValidEmail=0;
    else
    {
        var EmailValue=Obj.value;
        var EmailID=Obj.id;
        var EmailCount=$('#User'+UserID+'EmailDiv').children("div").length;
        for (var j=1;j<=EmailCount;j++) 
        {
            var NewEmailObj=document.getElementById('txtUser'+UserID+'Email'+j);
            var NewEmailValue=NewEmailObj.value;
            var NewEmailID=NewEmailObj.id;
            if (NewEmailID==EmailID) continue;
            if (NewEmailValue==EmailValue)
            {
                ValidEmail=0;
                break;
            }
        }
    }
    if (ValidEmail==0)
    {
       Obj.style.background="#F99";
       return 0;
    }
    else
    {
       Obj.style.background="#9F9";
       return 1; 
    }
}
 function fAddUserEmail(User,Operation)
{
   var Users=User.split('User');
   var UserID=Users[1];
   var EmailCount=$('#User'+UserID+'EmailDiv').children("div").length;
   var ValidEmail=1;
   for (var i=1;i<=EmailCount;i++)
   {
        var ChkEmail=fValidateUserEmail(document.getElementById('txtUser'+UserID+'Email'+i),User);
        if (ChkEmail==0) ValidEmail=0;
   }
   if (Operation!='Adjust')
   {
       if (ValidEmail==0)
       {
            window.parent.AlertMsg('<?php echo _('Please enter a valid and unique email in user'); ?> '+UserID);
            return;
       }
   }
   EmailID=EmailCount+1;
   var ParentDiv=document.getElementById('User'+UserID+'EmailDiv');
   var ChildDiv=document.createElement('div');
   var divEmailID='divUser'+UserID+'Email'+EmailID;
   ChildDiv.setAttribute('id',divEmailID);
   NewEmail="<table cellspacing='0' cellpadding='0'>\
                <tr>\
                    <td><input class='child' size=44 maxlength=50 name='txtUser"+UserID+"Email"+EmailID+"' type='text' style='background-color:#F99;'  id='txtUser"+UserID+"Email"+EmailID+"' onfocus='ChangeBackground(this);' onblur=\"return fCheckUserEmail(this,'User"+UserID+"');\" autocomplete='off'></td>\
                    <td nowrap>&nbsp;</td>\
                    <td nowrap><input class='child' type='radio' name='optUser"+UserID+"EmailDefault' id='optUser"+UserID+"EmailDefault"+EmailID+"' value="+EmailID+" /></td>\
                    <td nowrap><label class='child' for='optUser"+UserID+"EmailDefault"+EmailID+"'><strong><?php echo _('Default'); ?></strong></label></td>";
                    if (EmailCount==0)
                    {
                        NewEmail=NewEmail+"<td nowrap>&nbsp;</td>\
                        <td nowrap><img src='Images/blueplus.png' style='width:20px; height:20px;' onclick=\"fAddUserPhone('User"+UserID+"','New');\"></td>";
                    }
                    NewEmail=NewEmail+"<td nowrap>&nbsp;</td>\
                    <td nowrap><img src='Images/blueminus.png' style='width:22px; height:22px;' onClick=\"fRemoveUserEmail('User"+UserID+"',"+EmailID+");\"></a></td>\
                </tr>\
            </table>";
   ChildDiv.innerHTML=NewEmail;
   ParentDiv.appendChild(ChildDiv);
}
function fRemoveUserEmail(User,EmailID)
{
   var Users=User.split('User');
   var UserID=Users[1];
   var EmailCount=$('#User'+UserID+'EmailDiv').children("div").length;
   if (EmailCount==1) return; 
   var EmailList=new Array();
   var DefaultEmail=1;
   var Count=0;
   var ParentDiv=document.getElementById('User'+UserID+'EmailDiv');
   for (i=EmailID;i<=EmailCount;i++) 
   {
       var Email=Trim(document.getElementById('txtUser'+UserID+'Email'+i).value);
       if (document.getElementById('optUser'+UserID+'EmailDefault'+i).checked) DefaultEmail=i;
       var ChildDiv=document.getElementById('divUser'+UserID+'Email'+i);
       ParentDiv.removeChild(ChildDiv);
       if (i==EmailID) continue;
       EmailList[Count]=Email;
       Count=Count+1;
   }
   var ChildCount=$('#User'+UserID+'EmailDiv').children("div").length;
   for (i=0;i<EmailList.length;i++) 
   {
       fAddUserEmail(User,'Adjust');
       document.getElementById('txtUser'+UserID+'Email'+(ChildCount+i+1)).value=EmailList[i];
       var ChkEmail=fValidateUserEmail(document.getElementById('txtUser'+UserID+'Email'+(ChildCount+i+1)),'User'+UserID);
   }
   var ChildCount=$('#User'+UserID+'EmailDiv').children("div").length;
   for (i=1;i<=ChildCount;i++)  
   {
        if (i==(DefaultEmail-1)) document.getElementById('optUser'+UserID+'EmailDefault'+i).checked=true;
        else document.getElementById('optUser'+UserID+'EmailDefault'+i).checked=false;
   }
}
function fCheckLogin(ObjLogin)
{
    var ChkLoginExists=fCheckLoginExists(ObjLogin);
    if (ChkLoginExists==0) window.parent.AlertMsg('<?php echo _('The Chosen Login is either invalid or already exists in our records'); ?>');
    else window.parent.AlertMsg('<?php echo _('The Chosen Login is not found in our records'); ?>');
}
function fCheckLoginExists(ObjLogin)
{   
    var ChkLogin=fValidateSize(ObjLogin,'UserName');
    if (ChkLogin==0) return 0; 
    ValidLogin=1;
    var LoginID=ObjLogin.id;
    var Login=ObjLogin.value;
    var UsersCount=document.getElementById('txtUsers').value;
    for (var j=1;j<=UsersCount;j++) 
    {
        var NewLoginObj=document.getElementById('txtLogin'+j);
        var NewLoginValue=NewLoginObj.value;
        var NewLoginID=NewLoginObj.id;
        if (NewLoginID==LoginID) continue;
        if (NewLoginValue==Login)
        {
            ValidLogin=0;
            break;
        }
    }
    var ChkLoginExists=x_SelectUserByLogin(Login);
    if (ChkLoginExists!="") ValidLogin=0;
    if (ValidLogin==0)
    {
        ObjLogin.style.background="#F99";
        return 0;
    }
    else 
    {
        ObjLogin.style.background="#9F9";
        return 1;
    }
}
 
   function fAddUser(Operation)
{
    var ErrorMsg='';
    var UsersCount=$('#UserDiv').children('div').length;
    for (var i=1;i<=UsersCount;i++)
    {
        var ChkFirstName=fValidateName(document.getElementById('txtFirstName'+i));
        if (ChkFirstName==0) ErrorMsg+= '<?php echo _("Please enter valid First name in user"); ?> '+i+"<br>";
        var MiddleName=Trim(document.getElementById('txtMiddleName'+i).value);
        if (MiddleName!='')
        {
            var ChkMiddleName=fValidateName(document.getElementById('txtMiddleName'+i));
            if (ChkMiddleName==0) ErrorMsg+= '<?php echo _("Please enter valid Middle name in user"); ?> '+i+ "<br>";
        }
        var ChkLastName=fValidateName(document.getElementById('txtLastName'+i));
        if (ChkLastName==0) ErrorMsg+= '<?php echo _("Please enter valid Last name in user"); ?> '+i+ "<br>";
        var ChkLogin=fCheckLoginExists(document.getElementById('txtLogin'+i));
        if (ChkLogin==0) ErrorMsg+= '<?php echo _("Please enter valid and unique Login in user"); ?> '+i+"<br>";
        var ChkPassword=fValidateComplexPassword(document.getElementById('txtPassword'+i));
        if (ChkPassword==0) ErrorMsg+= '<?php echo _("Please enter Complex password in user"); ?> '+i+ "<br>";
        var Password=document.getElementById('txtPassword'+i).value;
        var ChkConfirmPassword=fConfirmPassword('User'+i);
        if (ChkConfirmPassword==0)
        {
            if (Password!='') ErrorMsg+= '<?php echo _("Password and confirm password did not match"); ?>'+ "<br>";
            else ErrorMsg+= '<?php echo _("Please enter Confirm password"); ?>'+ "<br>";
        }
        var ChkAnswer=fValidateSize(document.getElementById('txtAnswer'+UsersCount),'Subject');
        if (ChkAnswer==0) ErrorMsg+= '<?php echo _("Please enter the answer for Security question"); ?>'+ "<br>";
        var ValidPhone=1;
        var PhoneCount=$('#User'+UsersCount+'PhoneDiv').children('div').length;
        for (j=1;j<=PhoneCount;j++)
        {
            var ChkPhone=fValidateUserPhone(document.getElementById('txtUser'+i+'Phone'+j),'User'+i);
            if (ChkPhone==0) ValidPhone=0;
        }
        if (ValidPhone==0) ErrorMsg+= '<?php echo _("Please enter valid and unique Phone number in user"); ?> '+ i+"<br>";    
        var ValidEmail=1;
        var EmailCount=$('#User'+UsersCount+'EmailDiv').children('div').length;
        for (j=1;j<=EmailCount;j++)
        {
            var ChkEmail=fValidateUserEmail(document.getElementById('txtUser'+i+'Email'+j),'User'+i);
            if (ChkEmail==0) ValidEmail=0;
        }
        if (ValidEmail==0) ErrorMsg+= '<?php echo _("Please enter valid and unique Email in user"); ?> '+i+ "<br>";
    }
    if (Operation!='Adjust')
    {
        if(ErrorMsg!='')
        {
            AlertMsg(ErrorMsg);
            return false;
        }
    }
    UserID=UsersCount+1;
    var ParentDiv=document.getElementById('UserDiv');
    var ChildDiv=document.createElement('div');
    var divUserID='divUser'+UserID;
    ChildDiv.setAttribute('id',divUserID);
    NewUser="<div class='panel'>\
                <h2><?php echo _('User'); ?> "+UserID+"</h2><img src='Images/blueminus.png' style='width:22px; height:22px;' class='remove' id='removebutton' onClick='fRemoveUser("+UserID+");'>\
                  <div class='panelcontent'>\
                        <table cellpading=1 cellspacing=1>\
                            <tr>\
                                <td nowrap width=135>\
                                    <label class='child' for='txtTitle"+UserID+"'><strong><?php echo _('First name'); ?>*</strong></label>\
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
                                    <select class='child' size=1 id='cmbTitle"+UserID+"' Name='cmbTitle"+UserID+"'></select>\
                                </td>\
                                <td>\
                                    <table cellspacing=0 cellpadding=0>\
                                        <tr>\
                                            <td><input class='child' name='txtFirstName"+UserID+"' type='text' style='background-color:#F99;' size='30' id='txtFirstName"+UserID+"'  maxlength='50' onfocus='ChangeBackground(this);' onblur='return fValidateName(this);' autocomplete='off'></td>\
                                            <td nowrap>&nbsp;&nbsp;&nbsp;</td>\
                                            <td nowrap><label class='child' for='txtMiddleName"+UserID+"'><strong><?php echo _('Middle/Initial name'); ?></strong></label></td>\
                                             <td nowrap>&nbsp;&nbsp;&nbsp;</td>\
                                            <td nowrap><input class='child' size=30 maxlength=50 type='text' name='txtMiddleName"+UserID+"' id='txtMiddleName"+UserID+"' style='background-color:#FFFFFF;' onfocus='ChangeBackground(this);' onblur=\"if (this.value!='') return fValidateName(this);\" autocomplete='off'></td>\
                                        </tr>\
                                    </table>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td nowrap width=135><label class='child' for='txtLastName"+UserID+"'><strong><?php echo _('Last name'); ?>*</strong></label></td>\
                                <td><input class='child' name='txtLastName"+UserID+"' type='text' style='background-color:#F99;' size='30' id='txtLastName"+UserID+"' maxlength='50' onfocus='ChangeBackground(this);' onblur='return fValidateName(this);' autocomplete='off'></td>\
                            </tr>\
                            <tr>\
                                <td nowrap width=135><label class='child' for='optGender"+UserID+"'><strong><?php echo _('Gender'); ?>*</strong></label></td>\
                                <td nowrap>\
                                    <table cellspacing=0 cellpadding=0>\
                                        <tr>\
                                            <td nowrap><input class='child' type='radio' name='optGender"+UserID+"' id='optMale"+UserID+"' value='Male' checked/></td>\
                                            <td nowrap><label class='child' for='optMale"+UserID+"'><strong><?php echo _('Male'); ?></strong></label></td>\
                                            <td nowrap>&nbsp;&nbsp;&nbsp;</td>\
                                            <td nowrap><input class='child' type='radio' name='optGender"+UserID+"' id='optFemale"+UserID+"' value='Female'/></td>\
                                            <td nowrap><label class='child' for='optFemale"+UserID+"'><strong><?php echo _('Female'); ?></strong></label></td>\
                                        </tr>\
                                    </table>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td nowrap width=135><label class='child' for='txtLogin"+UserID+"'><strong><?php echo _('Login'); ?>*</strong></label></td>\
                                <td nowrap>\
                                    <table cellpadding=0 cellspacing=>\
                                        <tr>\
                                            <td nowrap><input class='child' name='txtLogin"+UserID+"' type='text' style='background-color:#F99;' size='30' id='txtLogin"+UserID+"' maxlength=50 onfocus='ChangeBackground(this);' onblur=\"return fValidateSize(this,'UserName');\" autocomplete='off'></td>\
                                            <td nowrap>&nbsp;</td>\
                                            <td nowrap><img src='Images/question.png' onmouseover=\"ToolTip('<?php echo _('Login should be more than 6 characters long'); ?>',550);\" onmouseout='ToolTip();'></td>\
                                            <td nowrap>&nbsp;</td>\
                                            <td nowrap><input type='button' name='btnCheck"+UserID+"' id='btnCheck"+UserID+"' class='cmdbutton' value='<?php echo _('Check'); ?>' onclick=\"fCheckLogin(document.getElementById('txtLogin"+UserID+"'));\"></td>\
                                        </tr>\
                                    </table>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td nowrap width=135><label class='child' for='txtPassword"+UserID+"'><strong><?php echo _('Password'); ?>*</strong></label></td>\
                                <td nowrap>\
                                    <table cellpadding=0 cellspacing=0>\
                                        <tr>\
                                            <td nowrap><input class='childpassword' name='txtPassword"+UserID+"' type='password' style='background-color:#F99;' size=30 id='txtPassword"+UserID+"' maxlength=50 onfocus='ChangeBackground(this);' onblur='return fValidateComplexPassword(this);' onpaste='return false;' onmousedown='fDisableRightClick();' onkeydown='fDisableCopyCutPaste();' autocomplete='off'></td>\
                                            <td nowrap>&nbsp;</td>\
                                            <td nowrap><img src='Images/question.png' onmouseover=\"ToolTip('<?php echo _('Password should be more than 6 characters long and should contain numbers, special characters and uppercase and lowercase alphabets'); ?>',550);\" onmouseout='ToolTip();'></td>\
                                        </tr>\
                                    </table>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td nowrap width=135><label class='child' for='txtConfirmPassword"+UserID+"'><strong><?php echo _('Confirm password'); ?>*</strong></label></td>\
                                <td><input class='childpassword' name='txtConfirmPassword"+UserID+"' type='password' style='background-color:#F99;' size='30' id='txtConfirmPassword"+UserID+"' maxlength='50' onfocus='ChangeBackground(this);' onblur=\"return fConfirmPassword('User"+UserID+"');\" onpaste='return false;' onmousedown='fDisableRightClick();' onkeydown='fDisableCopyCutPaste();' autocomplete='off'></td>\
                            </tr>\
                            <tr>\
                                <td nowrap width=135><label class='child' for='cmbQuestion"+UserID+"'><strong><?php echo _('Security question'); ?></strong></label></td>\
                                <td nowrap>\
                                    <table cellspacing=0 cellpadding=0>\
                                        <tr>\
                                            <td nowrap><div id='User"+UserID+"QuestionDiv'><select class='child' name='cmbQuestion"+UserID+"' size=1 id='cmbQuestion"+UserID+"'></select></div></td>\
                                            <td nowrap>&nbsp;</td>\
                                            <td nowrap><img name='imgNewQuestion"+UserID+"' id='imgNewQuestion"+UserID+"' src='Images/blueplus.png' style='width:20px; height:20px;' onclick=\"fShowAddNewOption(this,document.getElementById('divNewQuestion"+UserID+"'));\"></td>\
                                            <td nowrap>&nbsp;</td>\
                                            <td nowrap>\
                                                <div id='divNewQuestion"+UserID+"' style='visibility:hidden;'>\
                                                    <table cellpadding=0 cellspacing=0>\
                                                        <tr>\
                                                            <td><input name='txtNewQuestion"+UserID+"' class='child' type='text' style='background-color:#F99;'  size=30 id='txtNewQuestion"+UserID+"' maxlength=100 onfocus='ChangeBackground(this);' onblur=\"return fValidateSize(this,'Subject');\" autocomplete='off'></td>\
                                                            <td nowrap>&nbsp;</td>\
                                                            <td><input name='btnAddNew"+UserID+"' class='cmdbutton' type='button' id='btnAddNew"+UserID+"' value='<?php echo _('Add new'); ?>' onclick=\"fAddNewOption(document.getElementById('imgNewQuestion"+UserID+"'),document.getElementById('txtNewQuestion"+UserID+"'));\"></td>\
                                                        </tr>\
                                                    </table>\
                                                </div>\
                                            </td>\
                                        </tr>\
                                    </table>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td nowrap width=135><label class='child' for='txtAnswer"+UserID+"'><strong><?php echo _('Security answer'); ?>*</strong></label></td>\
                                <td><input class='child' name='txtAnswer"+UserID+"' type='text' style='background-color:#F99;' size=30  id='txtAnswer"+UserID+"' maxlength=100 onfocus='ChangeBackground(this);' onblur=\"return fValidateSize(this,'Subject');\" autocomplete='off'></td>\
                            </tr>\
                            <tr>\
                                <td nowrap width=135><label class='child' for='txtUser"+UserID+"Phone1'><strong><?php echo _('Phone'); ?>*</strong></label></td>\
                                <td nowrap>\
                                    <div id='User"+UserID+"PhoneDiv'>\
                                        <div id='divUser"+UserID+"Phone1'>\
                                            <table cellpadding=0 cellspacing=0>\
                                                <tr>\
												    <td nowrap><select class='child' name='PhoneDropdown"+UserID+"Phone1' id='PhoneDropdown"+UserID+"Phone1' size='1' style='background-color:#9F9;width:50px;' onchange=\"onchangeFunction(this.value,'"+UserID+"');\"  onfocus='ChangeBackground(this);' onblur='this.style.background=\"#9F9\";'></select></td>\
													<td nowrap>&nbsp;</td>\
                                                    <td nowrap><input class='child' size=30 maxlength=20 name='txtUser"+UserID+"Phone1' type='text' value='+1' style='background-color:#F99;'  id='txtUser"+UserID+"Phone1' onfocus='ChangeBackground(this);' onfocusout=\"fOffFocusOutFormat('"+UserID+"',1,'Add');\" onblur=\"return fCheckUserPhone(this,'User"+UserID+"');\" autocomplete='off'></td>\
                                                    <td nowrap>&nbsp;</td>\
                                                    <td nowrap><select class='child' name='cmbUser"+UserID+"Phone1' id='cmbUser"+UserID+"Phone1' size='1'></select></td>\
                                                    <td nowrap>&nbsp;</td>\
                                                    <td nowrap><img src='Images/blueplus.png' style='width:20px; height:20px;' onclick=\"fAddUserPhone('User"+UserID+"','New');\"></td>\
                                                    <td nowrap>&nbsp;</td>\
                                                    <td nowrap><img src='Images/blueminus.png' style='width:22px; height:22px;' onClick=\"fRemoveUserPhone('User"+UserID+"',1);\"></td>\
                                                </tr>\
                                            </table>\
                                        </div>\
                                    </div>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td nowrap width=135><label class='child' for='txtUser"+UserID+"Email'><strong><?php echo _('Email'); ?>*</strong></label></td>\
                                <td nowrap>\
                                    <div id='User"+UserID+"EmailDiv'>\
                                        <div id='divUser"+UserID+"Email1'>\
                                            <table cellspacing=0 cellpadding=0>\
                                                <tr>\
                                                    <td><input class='child' size=44 maxlength=50 name='txtUser"+UserID+"Email1' type='text' style='background-color:#F99;'  id='txtUser"+UserID+"Email1' onfocus='ChangeBackground(this);' onblur=\"return fCheckUserEmail(this,'User"+UserID+"');\" autocomplete='off'></td>\
                                                    <td nowrap>&nbsp;</td>\
                                                    <td nowrap><input class='child' type='radio' name='optUser"+UserID+"EmailDefault' id='optUser"+UserID+"EmailDefault1' value=1 checked /></td>\
                                                    <td nowrap><label class='child' for='optUser"+UserID+"EmailDefault1'><strong><?php echo _('Default'); ?></strong></label></td>\
                                                    <td nowrap>&nbsp;</td>\
                                                    <td nowrap><img src='Images/blueplus.png' style='width:20px; height:20px;' onclick=\"fAddUserEmail('User"+UserID+"');\"></td>\
                                                    <td nowrap>&nbsp;</td>\
                                                    <td nowrap><img src='Images/blueminus.png' style='width:22px; height:22px;' onClick=\"fRemoveUserEmail('User"+UserID+"',1);\"></td>\
                                                </tr>\
                                            </table>\
                                        </div>\
                                    </div>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td nowrap width=135><label class='child' for='cmbLanguage"+UserID+"'><strong><?php echo _('Language'); ?></strong></label></td>\
                                <td><select class='child' name='cmbLanguage"+UserID+"' size=1 id='cmbLanguage"+UserID+"'></select></td>\
                            </tr>\
                            <tr>\
                                <td nowrap width=135><label class='child' for='cmbRights"+UserID+"'><strong><?php echo _('User rights'); ?></strong></label></td>\
                                <td><select class='child' name='cmbRights"+UserID+"' size=1 id='cmbRights"+UserID+"'></select></td>\
                            </tr>\
                       </table>\
                  </div>\
            </div>";
    ChildDiv.innerHTML=NewUser;
    ParentDiv.appendChild(ChildDiv);
    QuestionOptObj=document.getElementById('cmbQuestion');
    NewQuestionOptObj=document.getElementById('cmbQuestion'+UserID);
    for (i=0;i<QuestionOptObj.options.length;i++) 
    {
      var CText=QuestionOptObj.options[i].text;
      var CValue=QuestionOptObj.options[i].value;
      var OptObj=new Option();
      OptObj.value=CValue;
      OptObj.text=CText;
      var OptLength=NewQuestionOptObj.options.length;
      NewQuestionOptObj[OptLength]=OptObj;
    }
    TypeOptObj=document.getElementById('cmbPhone1');
    NewTypeOptObj=document.getElementById('cmbUser'+UserID+'Phone1');
    for (i=0;i<TypeOptObj.options.length;i++) 
    {
      var CText=TypeOptObj.options[i].text;
      var CValue=TypeOptObj.options[i].value;
      var OptObj=new Option();
      OptObj.value=CValue;
      OptObj.text=CText;
      var OptLength=NewTypeOptObj.options.length;
      NewTypeOptObj[OptLength]=OptObj;
      if (CValue=='Mobile') NewTypeOptObj.options[OptLength].selected=true;
    }
	
   	var cleave3 = new Cleave('#txtUser'+UserID+'Phone1', {
		phone:true,
		phoneRegionCode: 'US'
	});
   PhTypeOptObj=document.getElementById('PhoneDropdown1');
   PhNewTypeOptObj=document.getElementById('PhoneDropdown'+UserID+'Phone1');
   for (i=0;i<PhTypeOptObj.options.length;i++) 
   {
      var CText=PhTypeOptObj.options[i].text;
      var CValue=PhTypeOptObj.options[i].value;
	  var splitvar=CText.split("(");
      var OptObj=new Option();
      OptObj.value=CValue;
      OptObj.text=CText;
      var OptLength=PhNewTypeOptObj.options.length;
      PhNewTypeOptObj[OptLength]=OptObj;
      if (CValue=="US") PhNewTypeOptObj.options[OptLength].selected=true;  
   }
	
    ForObj1=document.getElementById('cmbTitle');
    NewForObj1=document.getElementById('cmbTitle'+UserID);
    for (i=0;i<ForObj1.options.length;i++)
    {
      var FText1=ForObj1.options[i].text;
      var FValue1=ForObj1.options[i].value;
      var OptObj1=new Option();
      OptObj1.value=FValue1;
      OptObj1.text=FText1;
      var OptLength1=NewForObj1.options.length;
      NewForObj1[OptLength1]=OptObj1;
      if (FValue1=='Mr.') NewForObj1.options[OptLength1].selected=true;
    }
    LanguageOptObj=document.getElementById('cmbLanguage');
    NewLanguageOptObj=document.getElementById('cmbLanguage'+UserID);
    for (i=0;i<LanguageOptObj.options.length;i++) 
    {
      var CText=LanguageOptObj.options[i].text;
      var CValue=LanguageOptObj.options[i].value;
      var OptObj=new Option();
      OptObj.value=CValue;
      OptObj.text=CText;
      var OptLength=NewLanguageOptObj.options.length;
      NewLanguageOptObj[OptLength]=OptObj;
      if (CValue=='<?php echo $locale; ?>') NewLanguageOptObj.options[OptLength].selected=true;
    }
    RightsOptObj=document.getElementById('cmbRights');
    NewRightsOptObj=document.getElementById('cmbRights'+UserID);
    for (i=0;i<RightsOptObj.options.length;i++) 
    {
      var CText=RightsOptObj.options[i].text;
      var CValue=RightsOptObj.options[i].value;
      var OptObj=new Option();
      OptObj.value=CValue;
      OptObj.text=CText;
      var OptLength=NewRightsOptObj.options.length;
      NewRightsOptObj[OptLength]=OptObj;
      if (CValue=='View only') NewRightsOptObj.options[OptLength].selected=true;
    }
    document.getElementById('txtUsers').value=ParseNumber(document.getElementById('txtUsers').value)+1;
    ExpandCollapse('<?php echo _('User'); ?> '+UserID)
}
function fRemoveUser(UserID)
{
   var UserCount=$('#UserDiv').children("div").length;
   if (UserCount==1) return; 
   var ParentDiv=document.getElementById('UserDiv');
   var UserList=new Array();
   var Count=0;
   for (i=UserID;i<=UserCount;i++) 
   {
       var Title=document.getElementById('cmbTitle'+i).value;
       var FirstName=Trim(document.getElementById('txtFirstName'+i).value);
       var MiddleName=Trim(document.getElementById('txtMiddleName'+i).value);
       var LastName=Trim(document.getElementById('txtLastName'+i).value);
       var Gender='Female';
       if (document.getElementById('optMale'+i).checked)  Gender='Male';
       var Login=Trim(document.getElementById('txtLogin'+i).value);
       var Password=Trim(document.getElementById('txtPassword'+i).value);
       var ConfirmPassword=Trim(document.getElementById('txtConfirmPassword'+i).value);
       var SecurityQuestion=document.getElementById('cmbQuestion'+i).value;
       var SecurityAnswer=Trim(document.getElementById('txtAnswer'+i).value);
       var PhoneCount=$('#User'+i+'PhoneDiv').children("div").length;
       var PhoneList="";
       for (j=1;j<=PhoneCount;j++)
       {
           var Phone=Trim(document.getElementById('txtUser'+i+'Phone'+j).value);
           var PhoneType=document.getElementById('cmbUser'+i+'Phone'+j).value;
           PhoneList=PhoneList+Phone+"---"+PhoneType+"~!~"
       }
       PhoneList=PhoneList.substr(0,(PhoneList.length-3));
       var EmailCount=$('#User'+i+'EmailDiv').children("div").length;
       var EmailList="";
       var DefaultEmail=1;
       for (j=1;j<=EmailCount;j++)
       {
           var Email=Trim(document.getElementById('txtUser'+i+'Email'+j).value);
           if (document.getElementById('optUser'+i+'EmailDefault'+j).checked) DefaultEmail=j;
           EmailList=EmailList+Email+"~!~"
       }
       EmailList=EmailList.substr(0,(EmailList.length-3))+"---"+DefaultEmail;
       var Language=document.getElementById('cmbLanguage'+i).value;
       var Rights=document.getElementById('cmbRights'+i).value;
       var ChildDiv=document.getElementById('divUser'+i);
       ParentDiv.removeChild(ChildDiv);
       document.getElementById('txtUsers').value=ParseNumber(document.getElementById('txtUsers').value)-1;
       if (i==UserID) continue;
       UserList[Count]=Title+"~^~"+FirstName+"~^~"+MiddleName+"~^~"+LastName+"~^~"+Gender+"~^~"+Login+"~^~"+Password+"~^~"+ConfirmPassword+"~^~"+SecurityQuestion+"~^~"+SecurityAnswer+"~^~"+PhoneList+"~^~"+EmailList+"~^~"+Language+"~^~"+Rights;
       Count=Count+1;
   }
   var ChildCount=$('#UserDiv').children("div").length;
   for (i=0;i<UserList.length;i++) 
   {
       fAddUser2('Adjust');
       var UserValues=UserList[i].split('~^~');
       var TitleObj=document.getElementById('cmbTitle'+(ChildCount+i+1));
       for (j=0;j<TitleObj.options.length;j++)
       {
           if (TitleObj.options[j].value==UserValues[0])
           {
               TitleObj.options[j].selected=true;
               break;
           }
       }
       document.getElementById('txtFirstName'+(ChildCount+i+1)).value=UserValues[1];
       var ChkFirstName=fValidateName(document.getElementById('txtFirstName'+(ChildCount+i+1)));
       document.getElementById('txtMiddleName'+(ChildCount+i+1)).value=UserValues[2];
       if (UserValues[2]!='') var ChkMiddleName=fValidateName(document.getElementById('txtMiddleName'+(ChildCount+i+1)));
       document.getElementById('txtLastName'+(ChildCount+i+1)).value=UserValues[3];
       var ChkLastName=fValidateName(document.getElementById('txtLastName'+(ChildCount+i+1)));
       if (UserValues[4]=='Female') document.getElementById('optFemale'+(ChildCount+i+1)).checked=true;
       else document.getElementById('optMale'+(ChildCount+i+1)).checked=true;
       document.getElementById('txtLogin'+(ChildCount+i+1)).value=UserValues[5];
       var ChkLogin=fCheckLoginExists(document.getElementById('txtLogin'+(ChildCount+i+1)));
       document.getElementById('txtPassword'+(ChildCount+i+1)).value=UserValues[6];
       var ChkPassword=fValidateComplexPassword(document.getElementById('txtPassword'+(ChildCount+i+1)));
       document.getElementById('txtConfirmPassword'+(ChildCount+i+1)).value=UserValues[7];
       var ChkConfirmPassword=fConfirmPassword('User'+(ChildCount+i+1));
       var QuestionObj=document.getElementById('cmbQuestion'+(ChildCount+i+1));
       for (j=0;j<QuestionObj.options.length;j++)
       {
           if (QuestionObj.options[j].value==UserValues[8])
           {
               QuestionObj.options[j].selected=true;
               break;
           }
       }
       document.getElementById('txtAnswer'+(ChildCount+i+1)).value=UserValues[9];
       var ChkAnswer=fValidateSize(document.getElementById('txtAnswer'+(ChildCount+i+1)),'Subject');
       var PhoneList=UserValues[10].split('~!~');
       for (j=0;j<PhoneList.length;j++)
       {    
           if (j>0) fAddUserPhone('User'+(ChildCount+i+1),'Adjust');
           var PhoneValues=PhoneList[j].split('---');
           document.getElementById('txtUser'+(ChildCount+i+1)+'Phone'+(j+1)).value=PhoneValues[0];
           var PhoneTypeObj=document.getElementById('cmbUser'+(ChildCount+i+1)+'Phone'+(j+1));
           for (k=0;k<PhoneTypeObj.options.length;k++)
           {
               if (PhoneTypeObj.options[k].value==PhoneValues[1])
               {
                   PhoneTypeObj.options[k].selected=true;
                   break;
               }
           }
           var ChkPhone=fValidateUserPhone(document.getElementById('txtUser'+(ChildCount+i+1)+'Phone'+(j+1)),'User'+i);
       }
       var TempEmailList=UserValues[11].split('---');
       var EmailList=TempEmailList[0].split('~!~');
       for (j=0;j<EmailList.length;j++) 
       {
           if (j>0) fAddUserEmail('User'+(ChildCount+i+1),'Adjust');
           document.getElementById('txtUser'+(ChildCount+i+1)+'Email'+(j+1)).value=EmailList[j];
           var ChkEmail=fValidateUserEmail(document.getElementById('txtUser'+(ChildCount+i+1)+'Email'+(j+1)),'User'+i);
           if (j==TempEmailList[1]) document.getElementById('optUser'+(ChildCount+i+1)+'EmailDefault'+(j+1)).checked=true;
           else document.getElementById('optUser'+(ChildCount+i+1)+'EmailDefault'+(j+1)).checked=false; 
       }
       var LanguageObj=document.getElementById('cmbLanguage'+(ChildCount+i+1));
       for (j=0;j<LanguageObj.options.length;j++)
       {
           if (LanguageObj.options[j].value==UserValues[12])
           {
               LanguageObj.options[j].selected=true;
               break;
           }
       }
       var RightsObj=document.getElementById('cmbRights'+(ChildCount+i+1));
       for (j=0;j<RightsObj.options.length;j++)
       {
           if (RightsObj.options[j].value==UserValues[13])
           {
               RightsObj.options[j].selected=true;
               break;
           }
       }
   }
}
function fClearAll()
{
   var UserCount=$('#UserDiv').children("div").length; 
   var ParentDiv=document.getElementById('UserDiv');
   for (i=2;i<=UserCount;i++) 
   {
       var ChildDiv=document.getElementById('divUser'+i);
       ParentDiv.removeChild(ChildDiv);    
   }
   //document.getElementById('GeneralQuestionDiv').innerHTML=SyncAjax("MySQLConfiguration.php?GetValues=Questions&QuestionID=&Language=<?php echo $locale; ?>&RandomNumber="+Math.random());
   document.getElementById('User1QuestionDiv').innerHTML=SyncAjax("MySQLConfiguration.php?GetValues=Questions&QuestionID=1&Language=<?php echo $locale; ?>&RandomNumber="+Math.random());
   var PhoneCount=$('#User1PhoneDiv').children("div").length;
   var ParentDiv=document.getElementById('User1PhoneDiv');
   for (i=2;i<=PhoneCount;i++)
   {
      var ChildDiv=document.getElementById('divUser1Phone'+i);
      ParentDiv.removeChild(ChildDiv);
   }
   var PhoneTypeObj=document.getElementById('cmbUser1Phone1');
   for (i=0;i<PhoneTypeObj.options.length;i++) 
   {
        if (PhoneTypeObj.options[i].value=='Mobile')
        {
            PhoneTypeObj.options[i].selected=true;
            break;
        }
   }
   var EmailCount=$('#User1EmailDiv').children("div").length;
   var ParentDiv=document.getElementById('User1EmailDiv');
   for (i=2;i<=EmailCount;i++)
   {
      var ChildDiv=document.getElementById('divUser1Email'+i);
      ParentDiv.removeChild(ChildDiv);
   }
   document.getElementById('optUser1EmailDefault1').checked=true;
   var LanguageObj=document.getElementById('cmbLanguage1');
   for (i=0;i<LanguageObj.options.length;i++) 
   {
        if (LanguageObj.options[i].value=='en_US')
        {
            LanguageObj.options[i].selected=true;
            break;
        }
   }
   fClear();
   document.getElementById('txtUsers').value=1;
   document.getElementById('txtMiddleName1').style.background='#FFFFFF';
}
 
function fValidateForm()
{
	var PassPattenStr=/^([0-9]|[A-Z]){6,}$/;
	var usertype=document.getElementById('cmbUserType').value;
	if (usertype=="")
	{
		window.parent.AlertMsg('Please select the User Type ');
		return false;
	}
	var ChkLoginName=document.getElementById('txtLogin1').value;
	if(!PassPattenStr.test(ChkLoginName))
	{
		var myElement = document.getElementById('txtLogin1');
        myElement.style.backgroundColor = '#ff9999';
		window.parent.AlertMsg('Login should be more than 6 characters and not Accepted character(!@#$%^&*)');
		return false; 
	}
	if (usertype=='Tenant') 
	{
		var ErrorMsg="";
		var Tenant=document.getElementById('TenantName').value;
		var Mail=Tenant.split('~');
		
		MailID=Mail[1];
		if (MailID=="")
		{
			alert('Please fill  contact details for selected Tenant in lease page ');
			return false;
		}
		var Loginname=document.getElementById('txtLoginTentant');
		 var ChkLogin=fCheckLoginExists(Loginname);
        if (ChkLogin==0) ErrorMsg+= '<?php echo _("Please enter valid and unique Login in user"); ?>'+ "<br>";
        var ChkPassword=fValidateComplexPassword(document.getElementById('txtPasswordTentant'));
        if (ChkPassword==0) ErrorMsg+= '<?php echo _("Please enter Complex password in user"); ?> '+ "<br>";
		var cnfPassword=document.getElementById('txtConfirmPasswordTentant').value;
		var Password=document.getElementById('txtPasswordTentant').value;
		
		if (cnfPassword=="")
		{
				
				ErrorMsg+= '<?php echo _("Please enter Confirm password"); ?>'+ "<br>";
		}
		else if (cnfPassword!=Password)
		{
			
			ErrorMsg+= '<?php echo _("Password and confirm password did not match"); ?>'+ "<br>";
		}
		
       
       
         if(ErrorMsg!='')
		{
			window.parent.AlertMsg(ErrorMsg);
			return false;
		}
		else
		{
			document.getElementById('txtUsers').disabled=false;
			document.getElementById('btnSubmitClone').value='Please wait ...';
			document.getElementById('btnSubmitClone').disabled=true;
			document.getElementById('btnSubmit').value='Success';
			document.body.style.cursor='wait';
			SubmitMsg('<?php echo _('Please wait while the form is being submitted'); ?><br>please do not refresh the page');
			x_SetSubmitSession('<?php echo session_id(); ?>','<?php echo $_SERVER['PHP_SELF']; ?>');
			document.AddUserForm.submit();
			return true;
		}       
	}
     var ErrorMsg="";
    //var UsersCount=document.getElementById('txtUsers').value;
    var UsersCount=1;
	
    for (k=1;k<=UsersCount;k++)
    {
        var ChkFirstName=fValidateName(document.getElementById('txtFirstName'+k));
        if (ChkFirstName==0) ErrorMsg+= '<?php echo _("Please enter valid First name in user"); ?> '+k+ "</br>";
        var MiddleName=Trim(document.getElementById('txtMiddleName'+k).value);
        if (MiddleName!='')
        {
            var ChkMiddleName=fValidateName(document.getElementById('txtMiddleName'+k));
            if (ChkMiddleName==0) ErrorMsg+= '<?php echo _("Please enter valid Middle name in user"); ?> '+k+ "<br>";
        }
        var ChkLastName=fValidateName(document.getElementById('txtLastName'+k));
        if (ChkLastName==0) ErrorMsg+= '<?php echo _("Please enter valid Last name in user"); ?> '+k+ "<br>";
        var ChkLogin=fCheckLoginExists(document.getElementById('txtLogin'+k));
        if (ChkLogin==0) ErrorMsg+= '<?php echo _("Please enter valid and unique Login in user"); ?>'+k+ "<br>";
        var ChkPassword=fValidateComplexPassword(document.getElementById('txtPassword'+k));
        if (ChkPassword==0) ErrorMsg+= '<?php echo _("Please enter Complex password in user"); ?> '+k+ "<br>";
        var Password=document.getElementById('txtPassword'+k).value;
        var ChkConfirmPassword=fConfirmPassword('User'+k);
        if (ChkConfirmPassword==0)
        {
            if (Password!='') ErrorMsg+= '<?php echo _("Password and confirm password did not match"); ?>'+ "<br>";
            else ErrorMsg+= '<?php echo _("Please enter Confirm password"); ?>'+ "<br>";
        }
        var ChkAnswer=fValidateSize(document.getElementById('txtAnswer'+k),'Subject');
        if (ChkAnswer==0) ErrorMsg+= '<?php echo _("Please enter the answer for Security question in user"); ?> '+k+ "<br>";
        ValidPhone=1;
        var PhoneCount=$('#User'+k+'PhoneDiv').children('div').length;
        for (i=1;i<=PhoneCount;i++)
        {
            var ChkPhone=fValidateUserPhone(document.getElementById('txtUser'+k+'Phone'+i),'User'+k);
            if (ChkPhone==0) ValidPhone=0;
        }
        if (ValidPhone==0) ErrorMsg+= '<?php echo _("Please enter valid and unique Phone number in user"); ?>'+k+ "<br>";
        var ValidEmail=1;
        var EmailCount=$('#User'+k+'EmailDiv').children('div').length;
        for (i=1;i<=EmailCount;i++)
        {
            var ChkEmail=fValidateUserEmail(document.getElementById('txtUser'+k+'Email'+i),'User'+k);
            if (ChkEmail==0) ValidEmail=0;
        }
        if (ValidEmail==0) ErrorMsg+= '<?php echo _("Please enter valid and unique Email in user"); ?> '+k+ "<br>";
    }
    if(ErrorMsg!='')
    {
        window.parent.AlertMsg(ErrorMsg);
        return false;
    }
    else
    {
        document.getElementById('txtUsers').disabled=false;
        document.getElementById('btnSubmitClone').value='Please wait ...';
        document.getElementById('btnSubmitClone').disabled=true;
        document.getElementById('btnSubmit').value='Success';
        document.body.style.cursor='wait';
        SubmitMsg('<?php echo _('Please wait while the form is being submitted'); ?><br>please do not refresh the page');
        x_SetSubmitSession('<?php echo session_id(); ?>','<?php echo $_SERVER['PHP_SELF']; ?>');
		window.parent.AlertMsg('Your Account Successfully added');
        document.AddUserForm.submit();
        return true;
    }       
}
function fDeactivate(UserID)
{
    var r=confirm("Are you sure?")
    if (r==true)
      {
          Status='2';
          window.parent.AlertMsg("<?php echo _('Account has been deactivated'); ?>");
           var Status=x_ActDeactivateUserAccount(UserID,Status);
           window.location.href='<?php echo $_SERVER["PHP_SELF"]; ?>';
      }
    else
      {
     // alert("You pressed Cancel!")
      }
             
}
function fActivate(UserID)
{
    var r=confirm("Are you sure?")
    if (r==true)
      {
           Status='0';
        window.parent.AlertMsg("<?php echo _('Account has been activated'); ?>");
        var Status=x_ActDeactivateUserAccount(UserID,Status);         
        window.location.href='<?php echo $_SERVER["PHP_SELF"]; ?>';
      }
    else
      {
     // alert("You pressed Cancel!")
      }
    
}
function fGetStates(Obj)
{
   var CountryCode=Obj.value;
   var CountryID=Obj.id;
   var NewCountryID=CountryID.split('Country');
   var TempStateID=NewCountryID[1];
   var StateName=NewCountryID[0];
   var NewStateID=StateName.split('cmb');
   var TempStateName=NewStateID[1];
   var ReqStateID=TempStateName+'State'+TempStateID;
   if (window.ActiveXObject) AjaxObj2=new ActiveXObject("Microsoft.XMLHTTP");
   else if (window.XMLHttpRequest) AjaxObj2=new XMLHttpRequest();
   else AjaxObj2=null;
   if (AjaxObj2==null) window.parent.AlertMsg('<?php echo _('Your Browser does not support XML HTTP'); ?>');
   else
   {
        AjaxObj2.open("GET","MySQLConfiguration.php?GetValues=CountryStates&RandomNumber="+Math.random()+"&CountryCode="+CountryCode+"&StateID="+ReqStateID, true);
        AjaxObj2.send(null);
        AjaxObj2.onreadystatechange=function() { if (AjaxObj2.readyState==4) document.getElementById(ReqStateID+'Div').innerHTML=AjaxObj2.responseText; }
   }
}
function fGetuserType(userTypeObj1)
{

	document.getElementById('TenantDetList1').innerHTML="";
	document.getElementById('UnitS').innerHTML="";
	var userTypeObj=document.getElementById('cmbUserType');
	if (userTypeObj.value=='Tenant')
	{
		var PropertyObj=document.getElementById('cmbprop');
	//PropertyObj.options[PropertyObj.selectedIndex].value='Select a Property';
			PropertyObj.options[0].selected=true;  
			
		
		document.getElementById('TenantUser').style.display='block';
		document.getElementById('OtherUser').style.display='none';
		
	}
	else
	{
		document.getElementById('TenantUser').style.display='none';
		document.getElementById('OtherUser').style.display='block';
	}
	
}

function fGetUnits(PropertyObj)
{
	 var PropertyID=PropertyObj.options[PropertyObj.selectedIndex].value;
	
	if ((PropertyID=='Select a property')||(PropertyID=='No properties available'))
    {
        window.parent.AlertMsg('<?php echo _('Please select a property'); ?>');
        
    }
    else
    {
		
        if (window.ActiveXObject) AjaxObj=new ActiveXObject("Microsoft.XMLHTTP");
        else if (window.XMLHttpRequest) AjaxObj=new XMLHttpRequest();
        else AjaxObj=null;
        if (AjaxObj==null) window.parent.AlertMsg('<?php echo _('Your browser doesnot support XML HTTP'); ?>');
        else
        {
            AjaxObj.open("GET","MySQLConfiguration.php?GetValues=PropertyAllUnits&RandomNumber="+Math.random()+"&PropertyID="+PropertyID+"&Landlord=<?php echo $_SESSION['UserID']; ?>&CompanyUsers=<?php echo $_SESSION['CompanyUsers']; ?>&Language=<?php echo $locale; ?>", false);
            AjaxObj.send(null);
            document.getElementById('UnitS').innerHTML=AjaxObj.responseText;
        }
       
    }
	
}
function fGetleaseNames()
{
	var PropertyID=document.getElementById('cmbprop').value;
	var UnitID=document.getElementById('cmbUnit1Name').value;
	if ((PropertyID=='Select a property')||(PropertyID=='No properties available') ||(UnitID=='No units available'))
    {
        window.parent.AlertMsg('<?php echo _('Please select a property/Unit'); ?>');
		if (document.getElementById('cmbUnit1Name').value!="")
			{
				var UnitObj=document.getElementById('cmbUnit1Name');
				UnitObj.options[0].selected=true; 
			}
        
    }
    else
    {
		
        if (window.ActiveXObject) AjaxObj=new ActiveXObject("Microsoft.XMLHTTP");
        else if (window.XMLHttpRequest) AjaxObj=new XMLHttpRequest();
        else AjaxObj=null;
        if (AjaxObj==null) window.parent.AlertMsg('<?php echo _('Your browser doesnot support XML HTTP'); ?>');
        else
        {
            AjaxObj.open("GET","MySQLConfiguration.php?GetValues=TenantDetList1&RandomNumber="+Math.random()+"&PropertyID="+PropertyID+"&UnitID="+UnitID+"&Landlord=<?php echo $_SESSION['UserID']; ?>", false);
            AjaxObj.send(null);
            document.getElementById('TenantDetList1').innerHTML=AjaxObj.responseText;
        }
       
    }
	
	
	
}

</script>
<script language='javascript' type='text/javascript'>
$(document).ready(function() {
<?php
$SessionID=strtolower(session_id());
$PageName=strtolower($_SERVER['PHP_SELF']);
if (isset($_POST['btnSubmit']))
{
    if (isset($_SESSION[$SessionID.'---'.$PageName]))
    {
        require_once("ConvertEscapeSequence.php");
        unset($_SESSION[$SessionID.'---'.$PageName]);
        $CompanyID=SelectCompanyID($_SESSION['UserID']); 
        $Users=$_POST["txtUsers"];
		
		if ($_POST["cmbUserType"]=='Tenant')
		{
            $COmpanyID = $_SESSION['Company'] ;
			$Tenant=$_POST["TenantName"];
			$TenantDet=explode("~",$Tenant);
			$TenantID=$TenantDet[0];
			$Login=$_POST["txtLoginTentant"];
			$Password=$_POST["txtPasswordTentant"];
			$SecurityQuestion='What is your Favorite Color';
			$SecurityAns='No Idea';				
			$link="b6FxQadDQTOppSACRo2fghDqTYpbVFvfh7KAWA7zRJQGZT2FAFfPfKaxH7DDm1L";
			$statusTen=UpdateTenantLogin($TenantID, strtoupper($Login),md5($Password),$SecurityQuestion,$SecurityAns,$Email,$link,$CompanyID);
		}
		else{
			for ($k=1;$k<=$Users;$k++)
			{
				$Title=$_POST["cmbTitle".$k];
				$FirstName=$_POST["txtFirstName".$k];
				$MiddleName=$_POST["txtMiddleName".$k];
				$LastName=$_POST["txtLastName".$k];
				$NameList[$k]=$Title.$FirstName.' '.$MiddleName.' '.$LastName;
				$Gender=$_POST["optGender".$k];
				$AccountType='Basic';
				if ($k<1) $AccountType='Master'; 
				$Login=$_POST['txtLogin'.$k];
				$LoginList[$k]=$Login;
				$Password=$_POST["txtPassword".$k];
				$PasswordList[$k]=$Password;
				$SecurityQuestion=$_POST["cmbQuestion".$k];
				$Language=$_POST["cmbLanguage".$k];
				$LanguageList[$k]=$Language;
				$UserType=$_POST['cmbUserType'];
				$Rights=$_POST["cmbRights".$k];	
				$RightsList[$k]=$Rights;	
				if($Rights=='Management') $UserType='Manager';
				$Status=InsertDropDownValue($SecurityQuestion,$SecurityQuestion,'',$locale,'SecurityQuestion','0');
				$SecurityAnswer=$_POST["txtAnswer".$k];
				$DefaultOption=$_POST['optUser'.$k.'EmailDefault'];
				$CommunicationEmail=$_POST['txtUser'.$k.'Email'.$DefaultOption];
				$CommunicationEmailList[$k]=$CommunicationEmail;
				$ActivationLink="";
				for ($i=0;$i<75;$i++)
				{
					$RandNum=rand(48,122);
					if ((($RandNum>47)&&($RandNum<58))||(($RandNum>64)&&($RandNum<91))||(($RandNum>96)&&($RandNum<123))) $ActivationLink=$ActivationLink.chr($RandNum);
				}
				$UserRowID=InsertUser($Title,$FirstName,$MiddleName,$LastName,$Gender,'','','',$UserType,$CompanyID,$AccountType,$Login,$Password,$SecurityQuestion,$SecurityAnswer,$CommunicationEmail,$Language,'3',$ActivationLink,'',$Rights);
				$UserRowIDList[$k]=$UserRowID; 
				$ActivationLinkList[$k]=$ActivationLink;
				for ($m=1;$m>0;$m++)
				{
					if (!isset($_POST['txtUser'.$k.'Phone'.$m])) break;
					$Phone=$_POST['txtUser'.$k.'Phone'.$m];
					if(($_POST['PhoneDropdown'.$k.'Phone'.$m]=='US') || ($_POST['PhoneDropdown'.$k.'Phone'.$m]=='CA')){
						$Phoneex=explode(" ",$Phone);
						$Phone=$Phoneex[0]." ".$Phoneex[1]."-".$Phoneex[2]."-".$Phoneex[3];
						
					}
					//$Phone=$Phone."^".$_POST['cmbUser'.$k.'Phone'.$m]."^".$_POST['PhoneDropdown'.$k.'Phone'.$m];//PhoneDropdown1Phone1
					$CountryCode=$_POST['PhoneDropdown'.$k.'Phone'.$m];
					echo '<script type="text/javascript">alert("'.$Phone.'");</script>';
					$PhoneType=$_POST['cmbUser'.$k.'Phone'.$m];
					$AddPhone=InsertPhone('User',$UserRowID,$Phone,$PhoneType,$CountryCode);
				}
				for ($m=1;$m>0;$m++)
				{
					if (!isset($_POST['txtUser'.$k.'Email'.$m])) break;
					$Email=$_POST['txtUser'.$k.'Email'.$m];
					$AddEmail=InsertEmail($Email,'User',$UserRowID);
				}
        }
        $WebsiteHome=SelectConfigValue('WebsiteHome');
        $From=SelectConfigValue('AdminEmail');
        $ClientImagesDirectory=SelectConfigValue('ClientImagesDirectory');
        $EmailTemplatesDirectory=SelectConfigValue('EmailTemplatesDirectory');
        for ($k=1;$k<=$Users;$k++)
        {
            $UserRowID=$UserRowIDList[$k];
            $DocumentType='Default';
            $Landlord=$UserRowID;
            $DefaultDocFile="Defaultlease.html";
            $ClientImagesDirectory=SelectConfigValue('ClientImagesDirectory');
            $DefaultDocFileName=$ClientImagesDirectory.'DefaultDocument';
            $DefaultDocFileNamePath=$DefaultDocFileName.'/'.$DefaultDocFile; 
            $DTargetDocPath=$ClientImagesDirectory.'Landlord/'.$Landlord;
            $DTarget1=$DTargetDocPath.'/';
            $DTarget=$DTarget1.'Documents';
            if (!file_exists($DTarget)) 
            {
                mkdir($DTarget,0777,true);
            }
            $FilePath=$DTarget.'/'.$DefaultDocFile;
            copy($DefaultDocFileNamePath,$FilePath);
            $DocumentName='Default document';
            $DocumentLanguage=$locale;
            $Frequency='Monthly';
            $Currency='USD'; 
            $DocumentComments='Default document';
            $DocumentID=InsertDocument($Landlord,$DocumentName,$DocumentType,$Frequency,$DocumentLanguage,$Currency,'0','',$DocumentComments);
            $Status=CopyDocumentVariables($DocumentID);
            if (!file_exists($ClientImagesDirectory.'Landlord/'.$UserRowID)) mkdir($ClientImagesDirectory.'Landlord/'.$UserRowID,0777,true);
            $Language=$LanguageList[$k];
            $Name=$NameList[$k];
            $Login=$LoginList[$k];
            $Password=$PasswordList[$k];
            $ActivationLink=$ActivationLinkList[$k];
            $CommunicationEmail=$CommunicationEmailList[$k];
            $ActivationLink=$WebsiteHome."?locale=".$Language."&UserActivationLink=".$ActivationLink; 
            $To=$CommunicationEmail;
            $Subject=SelectMailSubject("SignUp",$Language);
            $MailTemplateFile=SelectMailTemplateFile("SignUp",$Language);
            $MailFileName=$EmailTemplatesDirectory.$MailTemplateFile;
            $MailTemplate="";
            if (is_file($MailFileName))
            {
                    ob_start();
                include $MailFileName;
                $MailTemplate=ob_get_contents();
                ob_end_clean();
            }
            $Login=stripslashes(htmlentities($Login,ENT_QUOTES));
            $Password=stripslashes(htmlentities($Password,ENT_QUOTES));
            $MailContent=str_replace("{SPMName}",$Name,$MailTemplate);
            $MailContent=str_replace("{Login}",$Login,$MailContent);
            $MailContent=str_replace("{Password}",'Your Chosen Password',$MailContent);
            $MailContent=str_replace("{ActivationLink}",$ActivationLink,$MailContent);
            $Status=EnqueueMail('SignUp',$From,$To,'','',$Subject,$MailContent,'','','0','');
			if ($Status)
			{
				$Finaly=SendMail(); 
			}
        }
        echo "<script> window.parent.AlertMsg('"._("Account(s) created successfully, an email with the activation link has been sent to your email")."');"."\n</script>";
    }
	}
}
?>
});
</script> 
</head>
<body class='nobackground'>
<script type="text/javascript" src="Javascripts/ToolTip.js"></script>
                <form method="post" id="AddUserForm" name="AddUserForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>"  onsubmit="return fValidateForm();">
                    <table cellpadding="1" cellspacing="1">
                        <tr>
                            <td>
                            <select class='child' size=1 id='cmbTitle' Name='cmbTitle' style='visibility:hidden;'> 
                            <?php
                            $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                            mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                            $DDVQuery="SELECT * FROM DropDownValues WHERE Purpose='Title'  AND DDVLanguage= '".$locale."' ORDER BY DDVID";
                            $ResultSet=mysql_query($DDVQuery);
                            if ($ResultSet)
                            {
                                while ($Fields=mysql_fetch_array($ResultSet))
                                {
                                     if ($Fields["DDVID"]=="Mr.") echo "<option value='".$Fields["DDVID"]."' selected>".$Fields["DDVName"]."<Selected></option>"."\n";
                                     else echo "<option value='".$Fields["DDVID"]."'>".$Fields["DDVName"]."</option>"."\n";
                                }
                            }
                            mysql_close($MySQLConnection);
                            ?> 
                            </select>
                            </td>
                            <td>
                                <div id='GeneralQuestionDiv'>
                                <select class='child' name='cmbQuestion' size=1 id='cmbQuestion' style='visibility:hidden;'>
                                <?php
                                $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                                mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                                $QuestionQuery="SELECT * FROM DropDownValues WHERE DDVLanguage='".$locale."' AND Purpose='SecurityQuestion' ORDER BY DDVID";
                                $ResultSet=mysql_query($QuestionQuery);
                                $QCount=0;
                                if ($ResultSet)
                                {
                                    while ($Fields=mysql_fetch_array($ResultSet))
                                    {
                                         echo "<option value='".$Fields['DDVID']."'>".$Fields['DDVName']." ?</option>"."\n";
                                    }
                                }
                                $QCount=mysql_num_rows($ResultSet);
                                mysql_close($MySQLConnection);
                                ?>
                                </select>   
                               </div> 
                            </td>
                                <td>
                                    <select class='child' name='cmbLanguage' size=1 id='cmbLanguage' style='visibility:hidden;'>
                                    <?php
                                    $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                                    mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                                    $LanguageQuery="SELECT * FROM Languages ORDER BY LCode";
                                    $ResultSet=mysql_query($LanguageQuery);
                                    if ($ResultSet)
                                    {
                                        while ($Fields=mysql_fetch_array($ResultSet))
                                        {
                                            if ($Fields["LCode"]==$locale) echo "<option value='".$Fields["LCode"]."' selected>".$Fields["LName"]."</option>"."\n";
                                            else echo "<option value='".$Fields["LCode"]."'>".$Fields["LName"]."</option>"."\n";
                                        }
                                    }
                                    mysql_close($MySQLConnection);
                                    ?>
                                    </select>
                                </td>
                            <td><input name="txtUsers" class='child' type='text' size="5" id="txtUsers" style="visibility: hidden" value=1 maxlength="5"  disabled onfocus="ChangeBackground(this);" onblur="return fValidateSize(this,'Units');" autocomplete="off"></td>
                            <td nowrap>
								<select class='child' name='PhoneDropdown1' id='PhoneDropdown1' size='1' style='background-color:#9F9;width:60px;visibility:hidden;' onfocus='ChangeBackground(this,"1");' onblur="this.style.background='#9F9';">
									<?php
									 $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
									 mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
													 $DDVQuery1="SELECT * FROM Countries WHERE RegionCode!=''";
													 $ResultSet1=mysql_query($DDVQuery1);
													 if ($ResultSet1)
													 {
														while ($Fields1=mysql_fetch_array($ResultSet1))
														{
														
															if ($Fields1['CCode']=="US") echo "<option value='".$Fields1['CCode']."' selected>".$Fields1['CCode']." - (".$Fields1['RegionCode'].") ".$Fields1['CName']."</option>"."\n";
															else echo "<option value='".$Fields1['CCode']."'>".$Fields1['CCode']." - (".$Fields1['RegionCode'].") ".$Fields1['CName']."</option>"."\n";  //$Fields1['CCode']
															
														}
													 }
									 mysql_close($MySQLConnection);
									 ?>
									 </select>
								</td>
							<td nowrap>&nbsp;</td>
							<td nowrap valign='top'>
                                <select class='child' name='cmbPhone1' id='cmbPhone1' size='1' style="visibility: hidden;">
                                <?php
                                 $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                                 mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                                 $DDVQuery="SELECT * FROM DropDownValues WHERE DDVLanguage='".$locale."' AND Purpose='ContactType' ORDER BY DDVID";
                                 $ResultSet=mysql_query($DDVQuery);
                                 if ($ResultSet)
                                 {
                                    while ($Fields=mysql_fetch_array($ResultSet))
                                    {
                                        if ($Fields['DDVID']=='Mobile') echo "<option value='".$Fields['DDVID']."' selected>".$Fields['DDVName']."</option>"."\n";
                                        else echo "<option value='".$Fields['DDVID']."'>".$Fields['DDVName']."</option>"."\n";
                                    }
                                    echo "<option value='"._('Other')."'>"._('Other')."</option>"."\n";
                                 }
                                 mysql_close($MySQLConnection);
                                 ?>
                                 </select>
                            </td>
                        </tr>
                    </table>
                    <?php
                        $FltrUserName="";
                        $FltrLogin="";
                        $FltrGender="";
                        $FltrAccountType="";
                        $FltrLanguage="";                        
                        $FltrSubmitFromDate="";
                        $FltrSubmitToDate="";
                        $FltrCommand="";
						$FltrAccountStatus="active";
						/*if (isset($_REQUEST['txtFltrUserName']))
                        {
							$FltrAccountStatus=$_REQUEST['radiobuttonstatus'];
							//echo "<script>alert('". $FltrAccountStatus."')</script>";  
						}*/
						
                        if (isset($_REQUEST['txtFltrUserName']))
                        {
                           $FltrUserName=trim($_REQUEST['txtFltrUserName']);
						   //echo "<script>alert('". $FltrUserName."')</script>"; 
                           $MySQLFltrUserName=strtolower($FltrUserName);
                        }
                        if (isset($_REQUEST['txtFltrLogin']))
                        {
                           $FltrLogin=trim($_REQUEST['txtFltrLogin']);
                           $MySQLFltrLogin=strtolower($FltrLogin);
                        }
                        if (isset($_REQUEST['txtFltrGender']))
                        {
                           $FltrGender=trim($_REQUEST['txtFltrGender']);
                           $MySQLFltrGender=strtolower($FltrGender);
                        }
                        if (isset($_REQUEST['txtFltrAccountType']))
                        {
                           $FltrAccountType=trim($_REQUEST['txtFltrAccountType']);
                           $MySQLFltrAccountType=strtolower($FltrAccountType);
                        }
                        if (isset($_REQUEST['txtFltrLanguage']))
                        {
                           $FltrLanguage=trim($_REQUEST['txtFltrLanguage']);
                           $MySQLFltrLanguage=strtolower($FltrLanguage);
                        }
                        if (isset($_REQUEST['txtFltrSubmitFromDate']))
                        {
                            $FltrSubmitFromDate=trim($_REQUEST['txtFltrSubmitFromDate']);
                            $MySQLFltrSubmitFromDate=$FltrSubmitFromDate;
                            $FltrSubmitFromDateValues=explode('/',$FltrSubmitFromDate);
                            if (sizeof($FltrStatusFromDateValues)==3)
                            {
                                $FltrSubmitFromDateMonth=$FltrSubmitFromDateValues[0];
                                $FltrSubmitFromDateDay=$FltrSubmitFromDateValues[1];
                                $FltrSubmitFromDateYear=$FltrSubmitFromDateValues[2];
                                if (checkdate($FltrSubmitFromDateMonth,$FltrSubmitFromDateDay,$FltrSubmitFromDateYear))
                                {
                                    $FltrSubmitFromDateString=$FltrSubmitFromDateYear."-".$FltrSubmitFromDateMonth."-".$FltrSubmitFromDateDay;
                                    $MySQLFltrSubmitFromDate=strtotime($FltrSubmitFromDateString);
                                }
                            }
                        }
                        if (isset($_REQUEST['txtFltrSubmitToDate']))
                        {
                            $FltrSubmitToDate=trim($_REQUEST['txtFltrSubmitToDate']);
                            $MySQLFltrSubmitToDate=$FltrSubmitToDate;
                            $FltrSubmitToDateValues=explode('/',$FltrSubmitToDate);
                            if (sizeof($FltrSubmitToDateValues)==3)
                            {
                                $FltrSubmitToDateMonth=$FltrSubmitToDateValues[0];
                                $FltrSubmitToDateDay=$FltrSubmitToDateValues[1];
                                $FltrSubmitToDateYear=$FltrSubmitToDateValues[2];
                                if (checkdate($FltrSubmitToDateMonth,$FltrSubmitToDateDay,$FltrSubmitToDateYear))
                                {
                                    $FltrSubmitToDateString=$FltrSubmitToDateYear."-".$FltrSubmitToDateMonth."-".$FltrSubmitToDateDay;
                                    $MySQLFltrSubmitToDate=strtotime($FltrSubmitToDateString);
                                }
                            }
                        }
                        
                        
                        $Count=0;        
						
					if($FltrAccountStatus=="active") {
						
                        $Query="SELECT * FROM UserInfo WHERE Company='".$_SESSION['Company']."' and (Status=0 or Status=4) ";
					} else if($FltrAccountStatus=="inactive"){
						$Query="SELECT * FROM UserInfo WHERE Company='".$_SESSION['Company']."' and Status=2";
					} else if($FltrAccountStatus=="notactivated"){
						$Query="SELECT * FROM UserInfo WHERE Company='".$_SESSION['Company']."' and Status=3";
					}
                        $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                        mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                        $ResultSet=mysql_query($Query);
                        if ($ResultSet)
                        {
                            while($Fields=mysql_fetch_array($ResultSet))
                            {
                                $UserInfoID=$Fields['ID'];                                
                                $UserName=$Fields["FirstName"]." ".$Fields["MiddleName"]." ".$Fields["LastName"]."</td>"."\n";
                                $ChkUserName=$UserName;
                                if ($ChkUserName=="") $ChkUserName="No data";
                                if ($FltrUserName=="") $MySQLFltrUserName=$ChkUserName;
                                $Login=$Fields["Login"];
                                $ChkLogin=$Login;
                                if ($ChkLogin=="") $ChkLogin="No data";
                                if ($FltrLogin=="") $MySQLFltrLogin=$ChkLogin;
                                $Gender=$Fields["Gender"];
                                $ChkGender=$Gender;
                                if ($ChkGender=="") $ChkGender="No data";
                                if ($FltrGender=="") $MySQLFltrGender=$ChkGender;
                                $AccountType=$Fields["AccountType"];
                                $ChkAccountType=$AccountType;
                                if ($ChkAccountType=="") $ChkAccountType="No data";
                                if ($FltrAccountType=="") $MySQLFltrAccountType=$ChkAccountType;
                                $UserLanguage=$Fields["UserLanguage"];
                                $Language=SelectLanguage($UserLanguage);
                                $ChkLanguage=$Language;
                                if ($ChkLanguage=="") $ChkLanguage="No data";
                                if ($FltrLanguage=="") $MySQLFltrLanguage=$ChkLanguage;
                                $Status=$Fields['Status'];                                
                                $SubmitDate=$Fields["SubmitDate"];
                                $ChkSubmitDate="No Date";
                                $SubmitDateValues=explode(" ",$SubmitDate);
                                $SubmitDateNewValues=explode("-",$SubmitDateValues[0]);
                                $SubmitDateMonth=$SubmitDateNewValues[1];
                                $SubmitDateDay=$SubmitDateNewValues[2];
                                $SubmitDateYear=$SubmitDateNewValues[0];
                                if (checkdate($SubmitDateMonth,$SubmitDateDay,$SubmitDateYear)) $ChkSubmitDate=strtotime($SubmitDateValues[0]);
                                if ($FltrSubmitFromDate=="") $MySQLFltrSubmitFromDate=$ChkSubmitDate;
                                if ($FltrSubmitToDate=="") $MySQLFltrSubmitToDate=$ChkSubmitDate;
                                
                                if ((stripos($ChkUserName, $MySQLFltrUserName)!==false)&&(stripos($ChkLogin, $MySQLFltrLogin)!==false)&&(stripos($ChkGender, $MySQLFltrGender)!==false)&&(stripos($ChkAccountType, $MySQLFltrAccountType)!==false)&&(stripos($ChkLanguage, $MySQLFltrLanguage)!==false)&&($ChkSubmitDate>=$MySQLFltrSubmitFromDate)&&($ChkSubmitDate<=$MySQLFltrSubmitToDate))
                                {   
                                    $Count++;
                                    $AddUserDetailsArray[$Count]=$UserInfoID."~^~".$UserName."~^~".$Login."~^~".$Gender."~^~".$AccountType."~^~".$Language."~^~".$Status."~^~".$SubmitDate;
                                }
                            }
                        }
                        //mysql_close($MySQLConnection);
                        $PageSize=10;
                        $PageNum=1;
                        if (isset($_REQUEST['PageSize']))
                        {
                            if ($_REQUEST['PageSize']!="") $PageSize=$_REQUEST['PageSize'];
                        }
                        if (isset($_REQUEST['PageNum']))
                        {
                            if ($_REQUEST['PageNum']!="") $PageNum=$_REQUEST['PageNum'];
                        }
                        $MinRec=$PageSize*($PageNum-1)+1;
                        if ($MinRec>$Count)
                        {
                            $PageNum=1;
                            $MinRec=$PageSize*($PageNum-1)+1;
                        }
                        $MaxRec=$PageSize*$PageNum;
                        if ($MaxRec>$Count) $MaxRec=$Count;
						echo "<div style='margin-top: -15px;'>";
                         echo "<label class='childhead' style='margin-left : 5px;''><strong>"._('Users details')."</strong></label><br><br>" ;
						 echo "<table class='Single' cellpadding=0 cellspacing=0 style='width : 300px; margin-top:-8px; margin-left : 5px;'>";
							echo "<thead>"."\n";
								echo "<tr bgcolor='#33CCFF' >"."\n";
									// echo "<th nowrap></th>"."\n";
									echo "<th colspan = '3' >Account Status</th>"."\n";
									 
								echo "</tr>"."\n";
							echo "</thead>"."\n";
							echo "<tbody>"."\n";
									echo "<tr>"."\n";
										echo "<td nowrap><input type='radio' id='active' name='radiobuttonstatus' value='active' onclick='fcheck()' checked  > "."\n";
										echo " Active</td>"."\n";
										/*$Landlordname=SelectLandlordName($_SESSION['UserID']);
										//echo "<script>alert('".$Landlordname[0]."')</script>";
										 
										$Length=sizeof($Landlordname); 
										//echo "<script>alert('".$Length."')</script>";
										$j=0;
										$ArrayValue="";
										while($j<$Length) {
											$ArrayValue=$ArrayValue.$Landlordname[$j];
											$j++;
											if($j<$Length) {
												$ArrayValue=$ArrayValue."<br>";
											}
											 
											
										}  
										echo "<td rowspan = '3'><center>". $ArrayValue."</center></td  >"."\n"; */
									//echo "</tr>"."\n";
								 	//echo "<tr>"."\n";
									if($FltrAccountStatus=="inactive") {
										echo "<td nowrap><input type='radio' id='inactive' name='radiobuttonstatus' onclick='fcheck()' value='inactive' checked > "."\n";
									} else {
										echo "<td nowrap><input type='radio' id='inactive' name='radiobuttonstatus' onclick='fcheck()' value='inactive' > "."\n";
									}									
										echo " InActive </td>"."\n";
									  
									//echo "</tr>"."\n"; 
									//echo "<tr>"."\n";
									if($FltrAccountStatus=="notactivated") {
										echo "<td nowrap><input type='radio' id='notactivated' name='radiobuttonstatus' onclick='fcheck()' value='notactivated' checked > "."\n";
									} else {
										echo "<td nowrap><input type='radio' id='notactivated' name='radiobuttonstatus' onclick='fcheck()' value='notactivated' > "."\n";
									}									
										echo " Not Activated </td>"."\n";
									  
									echo "</tr>"."\n";
							echo "</tbody>"."\n";
						echo "</table><br>";
						//$Array=$_REQUEST['status'];
						//echo "<script>alert('". $radio."')</script>";  
                        //echo "<div style='position : relative; left : 50%;  margin-top:-6px; margin-left : -370px; width : 740px;'>"; 
                        echo "<div style='position : relative;   width : auto;'>"; 
                            echo "<table class='resultset' id='CountDocumentId' >";
                                echo "<thead>";
                                    echo "<tr>"."\n";
                                        echo "<th  nowrap>"._('User name')."</th>"."\n";
                                        echo "<th  nowrap>"._('Login')."</th>"."\n"; 
                                        echo "<th  nowrap>"._('Gender')."</th>"."\n";
                                        echo "<th  nowrap>"._('Account type')."</th>"."\n";
                                        echo "<th  nowrap>"._('Language')."</th>"."\n"; 
                                        echo "<th  nowrap>"._('Date')."</th>"."\n"; 
                                        echo "<th nowrap align='center'></th>"."\n";
                                    echo "</tr>"."\n";
                                    echo "<tr>";
                                        echo "<th><input type='text' class='child' id='txtFltrUserName' name='txtFltrUserName' onkeyup='fCheckLoad(this,event);' maxlength='30' size='15' value='".$FltrUserName."' autocomplete='false'></th>"."\n";
                                        echo "<th><input type='text' class='child' id='txtFltrLogin' name='txtFltrLogin' maxlength='30' size='15' onkeyup='fCheckLoad(this,event);' value='".$FltrLogin."' autocomplete='false'></th>"."\n";
                                        echo "<th><input type='text' class='child' id='txtFltrGender' name='txtFltrGender' maxlength='30' size='15' onkeyup='fCheckLoad(this,event);' value='".$FltrGender."' autocomplete='false'></th>"."\n";
                                        echo "<th><input type='text' class='child' id='txtFltrAccountType' name='txtFltrAccountType' maxlength='30' onkeyup='fCheckLoad(this,event);' size='15' value='".$FltrAccountType."' autocomplete='false'></th>"."\n";
                                        echo "<th><input type='text' class='child' id='txtFltrLanguage' name='txtFltrLanguage' maxlength='15' size='5' onkeyup='fCheckLoad(this,event);' value='".$FltrLanguage."' autocomplete='false'></th>"."\n";
                                        echo "<th>"."\n";
                                            echo "<input type='text' class='child' id='txtFltrSubmitFromDate' name='txtFltrSubmitFromDate' maxlength='10' onkeyup='fCheckLoad(this,event);' size='15' value='".$FltrSubmitFromDate."' autocomplete='false'>"."\n";
                                            echo "<br>"._('to')."<br>"."\n";
                                            echo "<input type='text' class='child' id='txtFltrSubmitToDate' name='txtFltrSubmitToDate' maxlength='10' onkeyup='fCheckLoad(this,event);' size='15' value='".$FltrSubmitToDate."' autocomplete='false'>"."\n";
                                        echo "</th>"."\n";
                                        echo "<th><label>"._('Command')."</label></th>"."\n";
                                    echo "</tr>";                                        
                                echo "</thead>";
                                echo "<tbody>";
                                    if ($Count==0) 
                                    {
                                          echo "<tr><td nowrap='true' align='center' colspan=7>"._('No Data Available')."</td></tr>" ."\n";
                                    }
                                    else
                                    {
                                        $RecCnt=0;
                                        for ($ICnt=1;$ICnt<=sizeof($AddUserDetailsArray);$ICnt++)
                                        {
                                            $RecCnt=$RecCnt+1;
                                            if ($RecCnt<$MinRec) Continue;
                                            if ($RecCnt>$MaxRec) break;
                                            $FltrValues=explode("~^~",$AddUserDetailsArray[$ICnt]);
                                            $NewUserInfoID=$FltrValues[0];
                                            $NewUserName=$FltrValues[1];
                                            $NewLogin=$FltrValues[2]; 
                                            $NewGender=$FltrValues[3];
                                            $NewAccountType=$FltrValues[4];
                                            $NewLanguage=$FltrValues[5];                                                 
                                            $NewStatus=$FltrValues[6];                                                 
                                            $NewSubmitDate=$FltrValues[7];
                                            echo "<tr>"."\n";                                                
                                                echo "<td nowrap align='left'>".$NewUserName."</td>"."\n";
                                                echo "<td nowrap align='left'>".$NewLogin."</td>"."\n";
                                                echo "<td nowrap align='left'>".$NewGender."</td>"."\n";
                                                echo "<td nowrap align='center'>".$NewAccountType."</td>"."\n";
                                                echo "<td nowrap align='center'>".$NewLanguage."</td>"."\n";
                                                echo "<td nowrap align='center'>".date_format(date_create($NewSubmitDate),'m/d/Y')."</td>"."\n";                                        
                                                if (($NewStatus==0)||($NewStatus==4)) echo "<td nowrap align='center'><input name='btnDeActivateUser".$NewUserInfoID."' type='button' class='cmdbutton'  style=\"font-size: 1em;font-weight: bold;width:80px;\" id='btnDeActivateUser".$NewUserInfoID."' value='"._('Deactivate')."' onclick='fDeactivate(".$NewUserInfoID.");'></td>"."\n";
                                                else if ($NewStatus==2) echo "<td nowrap align='center'><input name='btnActivateUser".$NewUserInfoID."' type='button' class='cmdbutton'  style=\"font-size: 1em;font-weight: bold;width:80px;\" id='btnActivateUser".$NewUserInfoID."' value='"._('Activate')."' onclick='fActivate(".$NewUserInfoID.");'></td>"."\n";
                                                else if ($NewStatus==3) echo "<td nowrap align='center'><input name='btnActivateUser".$NewUserInfoID."' type='button' class='cmdbutton' disabled='disabled'  style=\"font-size: 1em;font-weight: bold;width:80px;\" id='btnActivateUser".$NewUserInfoID."' value='"._('Not activated')."' ></td>"."\n";
                                                //else echo "<td align='center'><input name='btnActivateUser".$NewUserInfoID."' type='button' class='cmdbutton'  style=\"font-size: 0.7em;font-weight: bold;width:80px;\" id='btnActivateUser".$NewUserInfoID."' value='"._('Activate')."' onclick='fActivate(".$NewUserInfoID.");'></td>"."\n";
                                             echo "</tr>"."\n";   
                                        }                                            
                                    }                                        
                                echo "</tbody>";
                            echo "</table>";
                        echo "</div>"."\n";
                     //   echo "<div style='position : relative; left : 50%; margin-left : -370px; width : 740px;'>";
                        echo "<div style='position : relative;   width : auto;'>";
                            echo "<table id='tablefooter' cellspacing=0 cellpadding=0 width='100%'>"."\n";
                                echo "<tr>"."\n";
                                if ($Count==0) echo "<td nowrap='true' align='center' colspan=7>&nbsp;</td>"."\n";
                                else
                                {
                                    echo "<td nowrap='true' align='left'>Rows : ".$MinRec." - ".$MaxRec." / ".$Count."</td>"."\n";
                                    echo "<td nowrap='true'>&nbsp;</td>"."\n";
                                    echo "<td nowrap='true' align='center'>"."\n";
                                        echo "<table cellspacing=0 cellpadding=0 align='center'>"."\n";
                                            echo "<tr>"."\n";
                                                echo "<td nowrap='true'><a href='#' onclick=\"fChangePage('First');\"><img src='Images/first.gif' style='border:none;'></a></td>"."\n";
                                                echo "<td nowrap='true'><a href='#' onclick=\"fChangePage('Previous');\"><img src='Images/previous.gif' style='border:none;'></a></td>"."\n";
                                                echo "<td nowrap='true'>"."\n";
                                                    echo "Page : <select id='PageNum' name='PageNum' class='child' size=1 onchange='fLoadTable();'>"."\n";
                                                    $PageLimit=$Count/$PageSize;
                                                    $PageRemainder=$Count%$PageSize;
                                                    if ($PageRemainder!=0) $PageLimit=$PageLimit+1;
                                                    for ($PCnt=1;$PCnt<=$PageLimit;$PCnt++)
                                                    {
                                                        if ($PCnt==$PageNum) echo "<option value='".$PCnt."' selected>".$PCnt."</option>"."\n";
                                                        else  echo "<option value='".$PCnt."'>".$PCnt."</option>"."\n";
                                                    }
                                                    echo "</select>"."\n";
                                                echo "</td>"."\n";
                                                echo "<td nowrap='true'><a href='#' onclick=\"fChangePage('Next');\"><img src='Images/next.gif' style='border:none;'></a></td>"."\n";
                                                echo "<td nowrap='true'><a href='#' onclick=\"fChangePage('Last');\"><img src='Images/last.gif' style='border:none;'></a></td>"."\n";
                                            echo "</tr>"."\n";
                                        echo "</table>"."\n";
                                    echo "</td>"."\n";
                                    echo "<td nowrap='true'>&nbsp;</td>"."\n";
                                    echo "<td nowrap='true' align='right'>"."\n";
                                        echo "Number of Records : <select id='PageSize' name='PageSize' size=1 class='child' onchange='fLoadTable();'>"."\n";
                                            for ($SCnt=10;$SCnt<=50;$SCnt=$SCnt+10)
                                            {
                                                if ($SCnt==$PageSize) echo "<option value='".$SCnt."' selected>".$SCnt."</option>"."\n";
                                                else  echo "<option value='".$SCnt."'>".$SCnt."</option>"."\n";
                                            }
                                        echo "</select>"."\n";
                                    echo "</td>"."\n";
                                }
                                echo "</tr>"."\n";
                            echo "</table>"."\n";
                        echo "</div>";
                    ?>
                    <table cellspacing=1 cellpadding=1>
                        <tr>
                            <td nowrap><input class='cmdbutton' name='btnAddUser' id='btnAddUser' style='width: 150px;' type='button' onClick="fAddUser2();" value='<?php echo _('Add user'); ?>'></td>
                            <td>
							<td nowrap>
									<select class='child' name='PhoneDropdown' id='PhoneDropdown' size='1' style='background-color:#9F9;width:60px;visibility:hidden;' onfocus='ChangeBackground(this);' onblur="this.style.background='#9F9';">
										<?php
										 $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
										 mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
														 $DDVQuery1="SELECT * FROM Countries WHERE RegionCode!=''";
														 $ResultSet1=mysql_query($DDVQuery1);
														 if ($ResultSet1)
														 {
															while ($Fields1=mysql_fetch_array($ResultSet1))
															{
															
																if ($Fields1['CCode']=="US") echo "<option value='".$Fields1['CCode']."' selected>".$Fields1['CCode']." - (".$Fields1['RegionCode'].") ".$Fields1['CName']."</option>"."\n";
																else echo "<option value='".$Fields1['CCode']."'>".$Fields1['CCode']." - (".$Fields1['RegionCode'].") ".$Fields1['CName']."</option>"."\n";  //$Fields1['CCode']
																
															}
														 }
										 mysql_close($MySQLConnection);
										 ?>
										 </select>
									</td>
								<td nowrap>&nbsp;</td>
								
                                <select class='child' name='cmbPhone' id='cmbPhone' size='1' style='visibility:hidden;'>
                                <?php
                                 $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                                 mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                                 $DDVQuery="SELECT * FROM DropDownValues WHERE DDVLanguage='".$locale."' AND Purpose='ContactType' ORDER BY DDVID";
                                 $ResultSet=mysql_query($DDVQuery);
                                 if ($ResultSet)
                                 {
                                    while ($Fields=mysql_fetch_array($ResultSet))
                                    {
                                        if ($Fields['DDVID']=='Mobile') echo "<option value='".$Fields['DDVID']."' selected>".$Fields['DDVName']."</option>"."\n";
                                        else echo "<option value='".$Fields['DDVID']."'>".$Fields['DDVName']."</option>"."\n";
                                    }
                                    echo "<option value='"._('Other')."'>"._('Other')."</option>"."\n";
                                 }
                                 mysql_close($MySQLConnection);
                                 ?>
                                 </select>
                            </td>
                            <td nowrap>
                                <select name="cmbCompanyState" size="1" id="cmbCompanyState" class='child' style='visibility:hidden;'>
                                <?php
                                $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                                mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                                $StateQuery="SELECT * FROM States WHERE CCode='US' ORDER BY SName";
                                $ResultSet=mysql_query($StateQuery);
                                if ($ResultSet)
                                {
                                    while ($Fields=mysql_fetch_array($ResultSet))
                                    {
                                        echo "<option value='".$Fields["SCode"]."'>".$Fields["SName"]."</option>"."\n";
                                    }
                                }
                                mysql_close($MySQLConnection);
                                ?>
                                </select>
                            </td>
                             <td>
                                 <select class='child' name='cmbRights' size=1 id='cmbRights' style='visibility:hidden;'>
                                 <?php
                                    $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                                    mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                                    $LanguageQuery="SELECT * FROM DropDownValues WHERE DDVLanguage='".$locale."' AND Purpose='Rights' ORDER BY DDVID";
                                    $ResultSet=mysql_query($LanguageQuery);
                                    if ($ResultSet)
                                    {
                                        while ($Fields=mysql_fetch_array($ResultSet))
                                        {
                                             if ($Fields['DDVID']=='View only') echo "<option value='".$Fields['DDVID']."' selected>".$Fields['DDVName']."</option>"."\n";
                                             else echo "<option value='".$Fields['DDVID']."'>".$Fields['DDVName']."</option>"."\n";
                                        }
                                    }
                                    mysql_close($MySQLConnection);
                                 ?>
                                 </select>
                            </td>
                        </tr>
                    </table>
                    <div id='UserDiv' style="visibility: hidden;">
                        <div id='divUser1'>
                            <div class="panel">
                                <h2><?php echo _('User'); ?> 1</h2><img src='Images/blueminus.png' style='width:22px; height:22px;' class='remove' id='removebutton' onClick='fRemoveUser(1);'>
                                  <div class="panelcontent">
                                        <table cellpading=1 cellspacing=1  >
										<!--kiruthi-->
											<tr>
												<td nowrap width=135 colspan="1"><label class='child' for='txtuser'><strong><?php echo _('User Type'); ?>*</strong></label></td>
												<td>
													<select class='child' size=1 id='cmbUserType' Name='cmbUserType' style='background-color:#9F9;' onblur="this.style.background='#9F9';" onfocus="ChangeBackground(this);" onchange="fGetuserType(this)">
														<?php
														 $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
														 mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
														 $QueryUser="Select * from DropDownValues Where Purpose='UserType' AND DDVLanguage= '".$locale."' ORDER BY DDVID";
														 $ResultSet=mysql_query($QueryUser);
														 echo "<option value=''>Select One</option>"."\n";
														 if ($ResultSet)
														 {
															 while ($Fields=mysql_fetch_array($ResultSet))
															 {
																 echo "<option value='".$Fields["DDVID"]."'>".$Fields["DDVName"]."</option>"."\n";
															 }
														 }
															
														?>
													</select>
												</td>
											</tr>
											</table>
											
											<table cellpading=1 cellspacing=1 id='TenantUser' style='display:none'>
											
											<tr>
											
												 <td nowrap width=135 colspan="1"><label class='child' for='txtTitle1'><strong><?php echo _('Property name'); ?>*</strong></label></td>
												 <td>
												 
													<select class='child' size=1 id='cmbprop' Name='cmbprop' style='background-color:#9F9;' onblur="this.style.background='#9F9';" onfocus="ChangeBackground(this);" onchange='fGetUnits(this);' >
														<?php
														 $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
														 mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
														 $QueryProp="Select * from Property Where Landlord=".$_SESSION['UserID']."";														 
														 $ResultSet=mysql_query($QueryProp);
														 if ($ResultSet)
														 {
															  echo "<option value='Select a property'>Select a property</option>"."\n";
															 while ($Fields=mysql_fetch_array($ResultSet))
															 {
																 echo "<option value='".$Fields["ID"]."'>".$Fields["PropertyName"]."</option>"."\n";
															 }
														 }
															
														?>
													</select>
													</td> <td id='UnitS'></td>
													</tr>
													</table>
													
													<div id='TenantDetList1' ></div>	
										
											
											
											
											
											
										<!---end-->
										 <table cellpading=1 cellspacing=1 id='OtherUser' style='display:none'> 
                                              <tr >
                                                <td nowrap width=135 colspan="1"><label class='child' for='txtTitle1'><strong><?php echo _('First name'); ?>*</strong></label><y>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                   <select class='child' size=1 id='cmbTitle1' Name='cmbTitle1' style='background-color:#9F9;' onblur="this.style.background='#9F9';" onfocus="ChangeBackground(this);"> 
                                                    <?php
                                                    $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                                                    mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                                                    $DDVQuery="SELECT * FROM DropDownValues WHERE Purpose='Title'  AND DDVLanguage= '".$locale."' ORDER BY DDVID";
                                                    $ResultSet=mysql_query($DDVQuery);
                                                    if ($ResultSet)
                                                    {
                                                        while ($Fields=mysql_fetch_array($ResultSet))
                                                        {
                                                             if ($Fields["DDVID"]=="Mr.") echo "<option value='".$Fields["DDVID"]."' selected>".$Fields["DDVName"]."<Selected></option>"."\n";
                                                             else echo "<option value='".$Fields["DDVID"]."'>".$Fields["DDVName"]."</option>"."\n";
                                                        }
                                                    }
                                                    mysql_close($MySQLConnection);
                                                    ?> 
                                                    </select>
                                                </td>
                                                <td>
                                                    <table cellspacing=0 cellpadding=0>
                                                        <tr>
                                                            <td><input class='child' name='txtFirstName1' type='text' style='background-color:#F99;' size='30' id='txtFirstName1'  maxlength='50' onfocus='ChangeBackground(this);' onblur='return fValidateName(this);' autocomplete='off'></td>
                                                            <td nowrap>&nbsp;&nbsp;&nbsp;</td>
                                                            <td nowrap><label class='child' for='txtMiddleName1'><strong><?php echo _('Middle/Initial name'); ?></strong></label></td>
                                                             <td nowrap>&nbsp;&nbsp;&nbsp;</td>
                                                            <td nowrap><input class='child' size=30 maxlength=50 type='text' name='txtMiddleName1' id='txtMiddleName1' style='background-color:#DCDCDC;' onfocus='ChangeBackground(this);' onblur="this.style.background='#DCDCDC';"  onblur="if (this.value!='') return fValidateName(this);" autocomplete='off'></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td nowrap width=135><label class='child' for='txtLastName1'><strong><?php echo _('Last name'); ?>*</strong></label></td>
                                                <td><input class='child' name='txtLastName1' type='text' style='background-color:#F99;' size='30'  id='txtLastName1' maxlength='50' onfocus='ChangeBackground(this);' onblur='return fValidateName(this);' autocomplete='off'></td>
                                            </tr>
                                            <tr>
                                                <td nowrap width=135><label class='child'><strong><?php echo _('Gender'); ?>*</strong></label></td>
                                                <td nowrap>
                                                    <table cellspacing=0 cellpadding=0>
                                                        <tr>
                                                            <td nowrap><input class='child' type='radio' name='optGender1' id='optMale1' value='Male' checked/></td>
                                                            <td nowrap><label class='child' for='optMale1'><strong><?php echo _('Male'); ?></strong></label></td>
                                                            <td nowrap>&nbsp;&nbsp;&nbsp;</td>
                                                            <td nowrap><input class='child' type='radio' name='optGender1' id='optFemale1' value='Female'/></td>
                                                            <td nowrap><label class='child' for='optFemale1'><strong><?php echo _('Female'); ?></strong></label></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td nowrap width=135><label class='child' for='txtLogin1'><strong><?php echo _('Login'); ?>*</strong></label></td>
                                                <td nowrap>
                                                    <table cellspacing=0 cellpadding=0>
                                                        <tr>
                                                            <td nowrap><input class='child' name='txtLogin1' type='text' style='background-color:#F99;' size='30' id='txtLogin1' minlength='6' maxlength=50 onfocus='ChangeBackground(this);' onblur="return fValidateSize(this,'UserName');" autocomplete='off'></td>
                                                            <td nowrap>&nbsp;</td>
                                                            <td nowrap><img src='Images/question.png' onmouseover="ToolTip('<?php echo _('Login should be more than 6 characters long'); ?>',300);" onmouseout='ToolTip();'></td>
                                                            <td nowrap>&nbsp;</td>
                                                            <td nowrap colspan=2><input type='button' name='btnCheck1' id='btnCheck1' class='cmdbutton' value='<?php echo _('Check'); ?>' onclick="fCheckLogin(document.getElementById('txtLogin1'));"></td>
                                                        </tr>
                                                   </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td nowrap width=135><label class='child' for='txtPassword1'><strong><?php echo _('Password'); ?>*</strong></label></td>
                                                <td nowrap>
                                                    <table cellspacing=0 cellpadding=0>
                                                        <tr>
                                                            <td nowrap><input class='childpassword' name='txtPassword1' type='password' style='background-color:#F99;' size=30 id='txtPassword1'  maxlength=50 onpaste="return false;" onfocus='ChangeBackground(this);' onblur='return fValidateComplexPassword(this);' onpaste='return false;' onmousedown='fDisableRightClick();' onkeydown='fDisableCopyCutPaste();' autocomplete='off'></td>
                                                            <td nowrap>&nbsp;</td>
                                                            <td nowrap><img src='Images/question.png' onmouseover="ToolTip('<?php echo _('Password should be more than 6 characters long and should contain numbers, special characters and uppercase and lowercase alphabets'); ?>',300);" onmouseout='ToolTip();'></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td nowrap width=135><label class='child' for='txtConfirmPassword1'><strong><?php echo _('Confirm password'); ?>*</strong></label></td>
                                                <td><input class='childpassword' name='txtConfirmPassword1' type='password' style='background-color:#F99;' size='30'  id='txtConfirmPassword1' maxlength='50' onpaste="return false;" onfocus='ChangeBackground(this);' onblur="return fConfirmPassword('User1');" onpaste='return false;' onmousedown='fDisableRightClick();' onkeydown='fDisableCopyCutPaste();' autocomplete='off'></td>
                                            </tr>
                                            <tr>
                                                <td nowrap width=135><label class='child' for='cmbQuestion1'><strong><?php echo _('Security question'); ?></strong></label></td>
                                                <td nowrap>
                                                    <table cellspacing=0 cellpadding=0>
                                                        <tr>
                                                            <td nowrap>
                                                                <div id='User1QuestionDiv'>
                                                                    <select class='child' name='cmbQuestion1' size=1 id='cmbQuestion1' style='background-color:#DCDCDC;' onblur="this.style.background='#DCDCDC';" onfocus="ChangeBackground(this);">
                                                                    <?php
                                                                    $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                                                                    mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                                                                    $QuestionQuery="SELECT * FROM DropDownValues WHERE DDVLanguage='".$locale."' AND Purpose='SecurityQuestion' ORDER BY DDVID";
                                                                    $ResultSet=mysql_query($QuestionQuery);
                                                                    $QCount=0;
                                                                    if ($ResultSet)
                                                                    {
                                                                        while ($Fields=mysql_fetch_array($ResultSet))
                                                                        {
                                                                             echo "<option value='".$Fields['DDVID']."'>".$Fields['DDVName']." ?</option>"."\n";
                                                                        }
                                                                    }
                                                                    $QCount=mysql_num_rows($ResultSet);
                                                                    mysql_close($MySQLConnection);
                                                                    ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td nowrap>&nbsp;</td>
                                                            <td nowrap><img id='imgNewQuestion1' src='Images/blueplus.png' style='width:20px; height:20px;' onClick="fShowAddNewOption(this,document.getElementById('divNewQuestion1'));"></td>
                                                            <td nowrap>&nbsp;</td>
                                                            <td nowrap>
                                                                <div id='divNewQuestion1' style='visibility:hidden;'>
                                                                    <table cellpadding=0 cellspacing=0>
                                                                        <tr>
                                                                            <td><input name='txtNewQuestion1' class='child' type='text' style='background-color:#F99;'  size=30 id='txtNewQuestion1' maxlength=100 onfocus='ChangeBackground(this);' onblur="return fValidateSize(this,'Subject');" autocomplete='off'></td>
                                                                            <td nowrap>&nbsp;</td>
                                                                            <td><input name='btnAddNew1' class='cmdbutton' type='button' id='btnAddNew1' value='<?php echo _('Add new'); ?>' onclick="fAddNewOption(document.getElementById('imgNewQuestion1'),document.getElementById('txtNewQuestion1'));"></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td nowrap width=135><label class='child' for='txtAnswer1'><strong><?php echo _('Security answer'); ?>*</strong></label></td>
                                                <td><input class='child' name='txtAnswer1' type='text' style='background-color:#F99;' size=30  id='txtAnswer1' maxlength=100 onfocus='ChangeBackground(this);' onblur="return fValidateSize(this,'Subject');" autocomplete='off'></td>
                                            </tr>
                                            <tr>
                                                <td nowrap width=135><label class='child' for='txtUser1Phone1'><strong><?php echo _('Phone'); ?>*</strong></label></td>
                                                <td nowrap>
                                                    <div id='User1PhoneDiv'>
                                                        <div id='divUser1Phone1'>
                                                            <table cellpadding=0 cellspacing=0>
                                                                <tr>
																	<td nowrap>
																		<select class='child' name='PhoneDropdown1Phone1' id='PhoneDropdown1Phone1' size='1' onchange='onchangeFunction(this.value,"1")' style='background-color:#9F9;width:50px;' onfocus='ChangeBackground(this);' onblur="this.style.background='#9F9';">
																		<?php 
																		 $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
																		 mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
																		 $DDVQuery1="SELECT * FROM Countries WHERE RegionCode!=''";
																		 $ResultSet1=mysql_query($DDVQuery1);
																		 if ($ResultSet1)
																		 {
																			while ($Fields1=mysql_fetch_array($ResultSet1))
																			{
																			
																				if ($Fields1['CCode']=="US") echo "<option value='".$Fields1['CCode']."' selected>".$Fields1['CCode']." - (".$Fields1['RegionCode'].") ".$Fields1['CName']."</option>"."\n";
																				else echo "<option value='".$Fields1['CCode']."'>".$Fields1['CCode']." - (".$Fields1['RegionCode'].") ".$Fields1['CName']."</option>"."\n";  //$Fields1['CCode']
																				
																			}
																		 }
																		 mysql_close($MySQLConnection);
																		 ?>
																		 </select>
																	</td>
                                                                    <td nowrap><input class='child' size=30 maxlength=20 value='+1' name='txtUser1Phone1' type='text' style='background-color:#F99;' onfocusout='fOffFocusOutFormat(1,1,"Add");'  id='txtUser1Phone1' onfocus='ChangeBackground(this);' onblur="return fCheckUserPhone(this,'User1');" autocomplete='off'></td>
                                                                    <td nowrap>&nbsp;</td>
                                                                    <td nowrap>
                                                                        <select class='child' name='cmbUser1Phone1' id='cmbUser1Phone1' style='background-color:#9F9;' onblur="this.style.background='#9F9';" onfocus="ChangeBackground(this);" size='1'>
                                                                        <?php
                                                                         $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                                                                         mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                                                                         $DDVQuery="SELECT * FROM DropDownValues WHERE DDVLanguage='".$locale."' AND Purpose='ContactType' ORDER BY DDVID";
                                                                         $ResultSet=mysql_query($DDVQuery);
                                                                         if ($ResultSet)
                                                                         {
                                                                            while ($Fields=mysql_fetch_array($ResultSet))
                                                                            {
                                                                                if ($Fields['DDVID']=='Mobile') echo "<option value='".$Fields['DDVID']."' selected>".$Fields['DDVName']."</option>"."\n";
                                                                                else echo "<option value='".$Fields['DDVID']."'>".$Fields['DDVName']."</option>"."\n";
                                                                            }
                                                                            echo "<option value='"._('Other')."'>"._('Other')."</option>"."\n";
                                                                         }
                                                                         mysql_close($MySQLConnection);
                                                                         ?>
                                                                         </select>
                                                                    </td>
                                                                    <td nowrap>&nbsp;</td>
                                                                    <td nowrap><img src='Images/blueplus.png' style='width:20px; height:20px;' onclick="fAddUserPhone('User1','New');"></td>
                                                                    <td nowrap>&nbsp;</td>
                                                                    <td nowrap><img src='Images/blueminus.png' style='width:22px; height:22px;' onClick="fRemoveUserPhone('User1',1);"></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td nowrap width=135><label class='child' for='txtUser1Email1'><strong><?php echo _('Email'); ?>*</strong></label></td>
                                                <td nowrap>
                                                    <div id='User1EmailDiv'>
                                                        <div id='divUser1Email1'>
                                                            <table cellspacing=0 cellpadding=0>
                                                                <tr>
                                                                    <td><input class='child' size=44 maxlength=50 name='txtUser1Email1' type='text' style='background-color:#F99;'  id='txtUser1Email1' onfocus='ChangeBackground(this);' onblur="return fCheckUserEmail(this,'User1');" autocomplete='off'></td>
                                                                    <td nowrap>&nbsp;</td>
                                                                    <td nowrap><input class='child' type='radio' name='optUser1EmailDefault' id='optUser1EmailDefault1' value=1 checked /></td>
                                                                    <td nowrap><label class='child' for='optUser1EmailDefault1'><strong><?php echo _('Default'); ?></strong></label></td>
                                                                    <td nowrap>&nbsp;</td>
                                                                    <td nowrap><img src='Images/blueplus.png' style='width:20px; height:20px;' onclick="fAddUserEmail('User1','New');"></td>
                                                                    <td nowrap>&nbsp;</td>
                                                                    <td nowrap><img src='Images/blueminus.png' style='width:22px; height:22px;' onClick="fRemoveUserEmail('User1',1);"></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td nowrap width=135><label class='child' for="cmbLanguage1"><strong><?php echo _('Language'); ?></strong></label></td>
                                                <td>
                                                     <select class='child' name='cmbLanguage1' size=1  style='background-color:#DCDCDC;' onblur="this.style.background='#DCDCDC';" onfocus="ChangeBackground(this);" id='cmbLanguage1'>
                                                     <?php
                                                        $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                                                        mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                                                        $LanguageQuery="SELECT * FROM Languages ORDER BY LCode";
                                                        $ResultSet=mysql_query($LanguageQuery);
                                                        if ($ResultSet)
                                                        {
                                                            while ($Fields=mysql_fetch_array($ResultSet))
                                                            {
                                                                if ($Fields["LCode"]==$locale) echo "<option value='".$Fields["LCode"]."' selected>".$Fields["LName"]."</option>"."\n";
                                                                else echo "<option value='".$Fields["LCode"]."'>".$Fields["LName"]."</option>"."\n";
                                                            }
                                                        }
                                                        mysql_close($MySQLConnection);
                                                     ?>
                                                     </select>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td nowrap width=135><label class='child' for="cmbRights1"><strong><?php echo _('User rights'); ?></strong></label></td>
                                                <td>
                                                     <select class='child' name='cmbRights1' size=1 style='background-color:#DCDCDC;' onblur="this.style.background='#DCDCDC';" onfocus="ChangeBackground(this);" id='cmbRights1'>
                                                     <?php
                                                        $MySQLConnection= mysql_connect($MySQLHost,$MySQLUser,$MySQLPassword) or die(mysql_error());
                                                        mysql_select_db($MySQLDatabase,$MySQLConnection) or die(mysql_error());
                                                        $LanguageQuery="SELECT * FROM DropDownValues WHERE DDVLanguage='".$locale."' AND Purpose='Rights' ORDER BY DDVID";
                                                        $ResultSet=mysql_query($LanguageQuery);
                                                        if ($ResultSet)
                                                        {
                                                            while ($Fields=mysql_fetch_array($ResultSet))
                                                            {
                                                                 if ($Fields['DDVID']=='View only') echo "<option value='".$Fields['DDVID']."' selected>".$Fields['DDVName']."</option>"."\n";
																 else {
																	 if (($Fields['DDVID']=='Management')&&($_SESSION['Company']==0)) continue;     //singup page wont add management
																	 
																	 echo "<option value='".$Fields['DDVID']."'>".$Fields['DDVName']."</option>"."\n";
																 }
																 
                                                            }
                                                        }
                                                        mysql_close($MySQLConnection);
                                                     ?>
                                                     </select>
                                                </td>
                                            </tr>
                                       </table>
                                  </div>
                            </div>
                        </div>
                    </div>
					<div id='Submitbutton' style="visibility: hidden;">
                   <table cellpading=1 cellspacing=1 align='center'>
                        <tr>
                            <td><input type="button" name="btnSubmitClone" id="btnSubmitClone" class="cmdbutton" value="<?php echo _('Submit'); ?>" onclick='return fValidateForm();'></td>
                            <td><input type="hidden" name="btnSubmit" id="btnSubmit" value=""></td>
                            <td><input type="button" name="btnReset" id="btnReset" class="cmdbutton" value="<?php echo _('Reset'); ?>" onclick='fClearAll();'></td>
                        </tr>
                   </table>
				   </div>
				   </div>
                </form>
        <?php require_once('Content/Dialogs.php'); ?>
		 <script type="text/javascript" src="iframeresize/js/iframeResizer.contentWindow.min.js" defer ></script>
 <script>
			
		var cleave = new Cleave('#txtUser1Phone1', {
		phone:true,
		phoneRegionCode: 'US'
	});
		//alert("Hii");
		$('#cmbPhone1').change(function(){
    cleave.setPhoneRegionCode(this.value);
    cleave.setRawValue('');
    });
		</script>
</body>

<script type='text/javascript'>
function fAddUser2(Operation)
{
	document.getElementById("UserDiv").style.visibility = "visible";
	document.getElementById("Submitbutton").style.visibility = "visible"; 
	document.getElementById("removebutton").style.visibility = "hidden";
	
}

$(document).ready(function() {     
    $('#CountDocumentId').fixheadertable({
       // colratio : [150, 150, 150, 150, 150, 150, 150], 
        colratio : [ ,  ,  ,  ,  ,  ,  ], 
        height : 180,         
      //  width : 730, 
        minWidth : 1000,
        minWidthAuto : false,
        minColWidth : 50,
        addTitles : true,
        zebra: true,
        sortable : true,
        sortedColId : 0, 
        sortType : ['htmlstring', 'string', 'string', 'string', 'string', 'date', 'string'],
        dateFormat : 'm/d/Y',
        alignType : ['left', 'left', 'left', 'left', 'left', 'center', 'center'],
        titleType : ['yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no']
    });
});

document.body.style.cursor='auto'; 
var QuestionCount="<?php echo $QCount; ?>";
panelsStatus = {};
panelsStatus['<?php echo _('User'); ?> '+'1']="true";
setUpPanels();
window.parent.CloseSubmitMsg();
</script>
</html>
  
