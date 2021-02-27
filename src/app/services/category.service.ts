import { Injectable , OnInit} from '@angular/core';
import { Http , Response, RequestOptions } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';
import { Expense } from '../expense';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { AppSettings } from './constants';
import { map, catchError } from 'rxjs/operators';
@Injectable()
export class CategoryService {
  email : string='';
  //users = [];
   private _producturl='app/products.json';
  handleError: any;
  headers: any;
   constructor(private http: HttpClient){
    //this.uid= this.loginservice.getIndex();
   
   }

  // baseUrl = 'http://dailyroll.dinkhoo.com/';
   expenses=[];
  gettree(uid : string) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_treestruct.php',body);
     
  }
  getCategories(uid : string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
     
  }
  addcontact(contactname:any,contactemail : string,contactaddress:any,contactphone:any,selectaccountid:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({contactname:contactname,contactemail:contactemail,contactaddress:contactaddress,contactphone:contactphone,selectaccountid:selectaccountid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  addtreecontact(contactname:any,contactemail : string,contactaddress:any,contactphone:any,selectaccountid:any,selecttype:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({contactname:contactname,contactemail:contactemail,contactaddress:contactaddress,contactphone:contactphone,selectaccountid:selectaccountid,selecttype:selecttype,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  getContact(selectaccountid:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({selectaccountid:selectaccountid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  gettreeContact(selectaccountid:any,selecttype:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({selectaccountid:selectaccountid,selecttype:selecttype,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  addname(addname:any,selectaccountid:any,selectname:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({addname:addname,selectaccountid:selectaccountid,selectname:selectname,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  addbusname(addname:any,uid:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({addname:addname,uid:uid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  updatecontact(item:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({name:item.name,email:item.email,phone:item.phone,id:item.contactID,address:item.address,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  addaccname(addaccname:any,addamount:any,selectaccountid:any,selectname:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({addaccname:addaccname,addamount:addamount,selectaccountid:selectaccountid,selectname:selectname,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  updatesubacc(item:any,selectaccountid:any,selecttype:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({selectname:item.name,selectamount:item.amount,selectaccountid:selectaccountid,selecttype:selecttype,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  updatename(item:any,selectaccountid:any,selecttype:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({selectname:item.name,selectaccountid:selectaccountid,selecttype:selecttype,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  addsubcontact(contactname:any,contactemail : string,contactaddress:any,contactphone:any,selectsubacc:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({contactname:contactname,contactemail:contactemail,contactaddress:contactaddress,contactphone:contactphone,selectaccountid:selectsubacc,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  getSubContact(selectsubacc:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({selectaccountid:selectsubacc,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addcontact.php',body);
     
  }
  getAddcat(accountid:string,type:string, catname:string,uid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({accountid:accountid, type:type,catname:catname,uid: uid ,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
  }
  
   
  AddSubcat(categoryid:any,subcatname:string,defaultamount:string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({catid:categoryid,subcatname:subcatname,subcatdefaultamount:defaultamount,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
  }
   
   
  AddSubcatByCat(item:any,subcatnamebycat:string,subcatdefaultamount:string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({catid:item.cat_id,subcatname:subcatnamebycat,subcatdefaultamount:subcatdefaultamount,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
  }
  catInactive(item:any,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({catid:item.cat_id,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
  }
  catactive(item:any,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({catid:item.cat_id,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
  }
  subcatInactive(item:any,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({catid:item.subcat_id,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
  }
  updatesubcat(item:any,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({catid:item.cat_id,subcat_id:item.subcat_id,subcatname:item.subcat_name,amount:item.amount,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
  }
  updatecat(item:any,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({accountid:item.account_id,cattype:item.cat_type,categoryname:item.catname,cat_id:item.cat_id,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
  }
  subcatactive(item:any,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({catid:item.subcat_id,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
  }
  getCatList(uid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({uid: uid ,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
  }
  getAccountsList(uid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid ,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getdropdown.php',body);
  }
  addFedback(email :string,type:any,description:any){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ email:email,type:type,description:description});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_feedback.php',body);
 


  }

  insertFund(uid :string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid:uid});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_paymentsuccess.php',body);
 


  }
  getSubCategories(uid : string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_category.php',body);
     
  }
 
}
