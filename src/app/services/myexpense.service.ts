import { Injectable, OnInit } from '@angular/core';
import { Http , Response, RequestOptions } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';
import { Expense } from '../expense';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { AppSettings } from './constants';
import { map, catchError } from 'rxjs/operators';
import { LoginServiceService } from './login-service.service';

@Injectable()
export class MyexpenseService  {
  email : string='';
  //users = [];
   private _producturl='app/products.json';
  handleError: any;
  headers: any;
   constructor(private http: HttpClient){
    //this.uid= this.loginservice.getIndex();
   
   }

   baseUrl = 'http://dailyroll.dinkhoo.com/';
   expenses=[];
 
   getAll(uid : string,accountiddata:string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid: uid, accountid:accountiddata,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/my_ws_an_expense.php',body);
      /*.pipe(map((res) => {
        this.expenses.push(res['data']);
        return this.expenses;
      }),
      catchError(this.handleError));*/
  }
  getyear(uid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid ,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/getexpensetree.php',body);
  }
  getexpensestree(uid:any,accountid :string,penstatus:any,selectyear:any,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({uid:uid,accountid: accountid ,penstatus:penstatus,selectyear:selectyear,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/getexpensetree.php',body);
  }
  getMindate(accountid:string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid:accountid,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/my_ws_an_expense.php',body);

  }
  
  contactus(email:string, name:string,message:string,q:number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ name:name,email:email,message:message,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/my_ws_an_expense.php',body);
    
  }
  
  getDoc(expid : string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ expid: expid, q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/my_ws_an_expense.php',body);
      /*.pipe(map((res) => {
        this.expenses.push(res['data']);
        return this.expenses;
      }),
      catchError(this.handleError));*/
  }
  forgotpass(email :string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ email: email});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_forgotpass.php',body);
  }
  getAccountsList(uid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid ,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getdropdown.php',body);
  }
  getSearchAccountsList(uid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid ,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getdropdown.php',body);
  }
  getCategoryList(accountid :string,type:Number,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: accountid,type:type,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getdropdown.php',body);
  }
  searchAccount(uid:string,accountid :string,droppenstatus:string,selectyear:string,q:Number){
  
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid:uid,accountid: accountid,penstatus:droppenstatus,selectyear:selectyear,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/my_ws_an_expense.php',body);
  }
  searchstatus(uid:string,accountid :string,penstatus:string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid:uid,accountid: accountid,penstatus:penstatus,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/my_ws_an_expense.php',body);
  }
  getAmount(subcatid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ subcatid: subcatid,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getdropdown.php',body);
  }
  getSubCategoryList(catid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ catid: catid,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getdropdown.php',body);
  }
  getCategories(){
    return this.http.get(AppSettings.BASE_URL+'/ws_an_category.php');
  }
  uploadImage(formdata:any){
    var headers= new Headers();
    headers.append('enctype', 'multipart/form-data');
    headers.append('Accept', 'application/json');
    //let options = new RequestOptions({ headers: this.headers });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_fileupload.php',formdata);
  }
  uploadImage1(formdata:any){
    var headers= new Headers();
    headers.append('enctype', 'multipart/form-data');
    headers.append('Accept', 'application/json');
    //let options = new RequestOptions({ headers: this.headers });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_fileupload1.php',formdata);
  }
  saveExpense(accountid:string,catid:string,subcatid:string,description:string,amount:string,expdate:string,uid :string,filename:string,addstatus:string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({description:description,amount:amount,expdate:expdate,accountid:accountid,catid:catid,subcatid:subcatid,uid : uid,filename :filename,addstatus:addstatus});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addexpense.php',body);
    //.catch(this._errorhandler);
  }
  saveexp(accountid:string,catid:string,subcatid:string,description:string,amount:string,expdate:string,uid :string,filename:string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({description:description,amount:amount,expdate:expdate,accountid:accountid,catid:catid,subcatid:subcatid,uid : uid,filename :filename});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addexp.php',body);
    //.catch(this._errorhandler);
  }
  updateProduct(item:any,uid:string,filename:string){
    debugger;
    let body = JSON.stringify({description:item.description,amount:item.amount,date1:item.date,account:item.accountid,category:item.catid,subcategory:item.subcatid,id : item.expense_id,pendingstatus:item.pendingstatus,uid:uid,filename :filename});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_update_expense.php',body);
  }
  updateexp(item:any,uid:string,filename:string){
    debugger;
    let body = JSON.stringify({description:item.description,amount:item.amount,date1:item.date,account:item.accountid,category:item.catid,subcategory:item.subcatid,id : item.expense_id,pendingstatus:item.pendingstatus,uid:uid,filename :filename});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_update_expen.php',body);
  }
  updateProduct1(item:any,uid:string,filename:string,q:Number){
    debugger;
    let body = JSON.stringify({description:item.description,amount:item.amount,date1:item.date,account:item.accountid,category:item.catid,subcategory:item.subcatid,id : item.expense_id,pendingstatus:item.pendingstatus,uid:uid,filename :filename,q :q});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_update_expense1.php',body);
  }
 
  
  deleteProduct(item:any){
    debugger;
    let body = JSON.stringify({id : item.expense_id});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_expense_delete.php',body);
  }
  /* _errorhandler(error: Response) {
    //throw new Error("Method not implemented.");
    return Observable.throw(error || 'some error occured on server');
  }*/
  savebulkData(uid:string,accountid:string,tdate:string,cate:string,subcat:string,desc:string,amount:string,filename:string){
    debugger;
    let body = JSON.stringify({uid:uid,accountid:accountid,tdate:tdate,category:cate,subcat:subcat,desc:desc,amount : amount,filename :filename});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_blukexpenses.php',body);
  

  }
}