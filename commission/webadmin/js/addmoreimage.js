// JavaScript Document

function deleteinput(pos,delid)
{
	
	answer = confirm("Do you want to delete this item?")

		if (answer ==0) 
		{ 
			return false;
		} 
		else
		{
			var pr_doccount= document.getElementById('pr_doccount').value;
			orig_pr_doccount=Number(pr_doccount);
			if(pr_doccount!=0)
			{	
				pr_doccount=Number(pr_doccount)+Number(1);
				var reducenumber=Number(pos);
				
				var document2=document.getElementById('document').value+',';
				var rmvfile=document.getElementById('hiddendoc'+pos).value;
				
				doc=document2.replace(rmvfile+',', "");
				doc = doc.replace(/^,|,$/g,'')
				document.getElementById('document').value=doc;				
				
				$('.pos'+pos).remove();
				
				for(var s=1; s<pr_doccount; s++)
				{
					
					if(pos<s)
					{
						var rdnum=Number(s)-Number(1);
						$('.pos'+s+ ' .lang_remove').attr('onclick', 'deleteinput('+rdnum+')');
						$('.pos'+s).toggleClass('pos'+rdnum)
						$('.pos'+s).removeClass('pos'+s);	
						document.getElementById('pr_errmsg').style.display="none";	
						document.getElementById("hiddendoc"+s).setAttribute("id","hiddendoc"+rdnum);				
					}
					
				}
				
				if(delid!='' && delid >0)
				{ 
					 
					var result= null;
						$.ajax({
							url: 'deleteimage1.php',				
							data: {delid: delid},
							
							cache: false,
							async: false, // boo!
							success: function(data) {				
								result= data; 		
							}
						});		
				}
						
						
				
				var orig_pr_doccount= document.getElementById('pr_doccount').value;				
				document.getElementById('pr_doccount').value= Number(orig_pr_doccount)- Number(1);
				
			}	
	
		}
	
}
function addinput(type,name,val) {

	var pr_doccount= document.getElementById('pr_doccount').value;
	
	
	delid=document.getElementById('hiddenid').value;
	cont=document.getElementById('pr_doccount').value;
	cnt=Number(cont)+ Number(1);
	
	if(cont>0)
	{
	
		
	var file= document.getElementById('hiddendoc'+cont).value;
	
	var FileExt = file.substr(file.lastIndexOf('.')+1);
	
	if(file=="")
	{
	alert("Please upload image!");
	document.getElementById('hiddendoc1').focus();
	return false;
	}
	else if (FileExt != "png" && FileExt != "gif" && FileExt != "jpg" && FileExt != "jpeg" && FileExt != "tiff" && FileExt != "JPG" && FileExt != "PNG" )
	{
	
	alert("Image format is incorrect");
	return false;
	}
	
	
	if((document.getElementById('pr_doccount').value)<100)
	{
	document.getElementById('pr_doccount').value=Number(pr_doccount) + Number(1);
	var foo = document.getElementById("fooBar");
	var iDiv = document.createElement('div');
	iDiv.id = 'pos'+cnt;
	iDiv.className = 'pos'+cnt;	
	foo.appendChild(iDiv);	
	
	var availdiv = document.getElementById("pos"+cnt);
			
	var compimage = document.createElement("input");
	compimage.setAttribute("type", type);
	compimage.setAttribute("value", val);
	compimage.setAttribute("name", name);
	compimage.setAttribute("onchange", 'getlogo_image('+cnt+')');
	compimage.setAttribute("id", "prod_img"+cnt);
	compimage.setAttribute("class", "form-control inputfile pos"+cnt);	
	availdiv.appendChild(compimage);
	
	var compimage_date_id = document.createElement("input");
	compimage_date_id.setAttribute("type", "hidden");
	compimage_date_id.setAttribute("value", "");
	compimage_date_id.setAttribute("name", "hiddendoc[]");
	compimage_date_id.setAttribute("class", "form-control pos"+cnt);
	compimage_date_id.setAttribute("id", "hiddendoc"+cnt);
	

	availdiv.appendChild(compimage_date_id);
	
	
	var ahref = document.createElement("a");
	
	ahref.className= 'lang_remove';
	ahref.innerHTML= '<img src="images/delete_button.png" style="margin-top:14px;float:right;">';
	ahref.setAttribute("onclick", "return deleteinput("+cnt+");");
	ahref.setAttribute("name", "lang_remove");
	availdiv.appendChild(ahref);
	
	var cleardiv = document.createElement('div');		
	cleardiv.className = 'clear pos'+cnt;	
	availdiv.appendChild(cleardiv);	
	
	var spacediv = document.createElement('div');		
	spacediv.className = 'space pos'+cnt;	
	availdiv.appendChild(spacediv);
	
	}	
	else
	{
		document.getElementById('pr_errmsg').style.display="block";
	}

}
}