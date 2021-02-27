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
export class MyincomeService {
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
   getIncomeList(uid : string,accountid:any,penstatus:string,selectyear:string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid: uid,accountid:accountid,penstatus:penstatus,selectyear:selectyear,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_myincome.php',body);
     
  }
  getDoc(expid : string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ expid: expid, q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_myincome.php',body);
      /*.pipe(map((res) => {
        this.expenses.push(res['data']);
        return this.expenses;
      }),
      catchError(this.handleError));*/
  }
    addNot(accountid :string,seltype:any,description:any,uid:any,q:Number){
   
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({accountid:accountid,seltype:seltype,description:description,uid:uid,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addnotifications.php',body);
  }
  uploadImage1(formdata:any){
  
    var headers= new Headers();
    headers.append('enctype', 'multipart/form-data');
    headers.append('Accept', 'application/json');
    //let options = new RequestOptions({ headers: this.headers });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_fileupload1.php',formdata);
  }
  uploadImage(formdata:any){
    var headers= new Headers();
    headers.append('enctype', 'multipart/form-data');
    headers.append('Accept', 'application/json');
    //let options = new RequestOptions({ headers: this.headers });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_fileupload.php',formdata);
  }
  uploadImage2(formdata:any){
  
    var headers= new Headers();
    headers.append('enctype', 'multipart/form-data');
    headers.append('Accept', 'application/json');
    //let options = new RequestOptions({ headers: this.headers });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_fileupload2.php',formdata);
  }
    getNot(uid:any,q:Number){
   
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({uid:uid,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addnotifications.php',body);
  }
  getyear(uid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid ,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/getexpensetree.php',body);
  }
  getincometree(uid:any,accountid :string,penstatus:any,selectyear:any,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({uid:uid,accountid: accountid ,penstatus:penstatus,selectyear:selectyear,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/getincometree.php',body);
  }
  getAmount(subcatid :string,q:Number){
   
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ subcatid: subcatid,q:q});
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
  getMindate(accountid:string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid:accountid,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/my_ws_an_expense.php',body);
      /*.pipe(map((res) => {
        this.expenses.push(res['data']);
        return this.expenses;
      }),
      catchError(this.handleError));*/
  }
  getAccountList(uid :string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid: uid });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_incomeaccounts.php',body);
  }
 
  getAccountsList(uid :string,q:Number){
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
  getSubCategoryList(catid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ catid: catid,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getdropdown.php',body);
  }

  saveIncome(account:string,category:string,subcatid:string,description:string,amount:string,indate:string,addstatus:string,uid :string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({description:description,amount:amount,subcatid:subcatid,indate:indate,account:account,category:category,addstatus:addstatus,uid : uid});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addincome.php',body);
    //.catch(this._errorhandler);
  }

  saveIncome1(account:string,category:string,subcatid:string,description:string,amount:string,indate:string,addstatus:string,uid :string,filepath:any){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({description:description,amount:amount,subcatid:subcatid,indate:indate,account:account,category:category,addstatus:addstatus,uid : uid,filepath:filepath});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addincome1.php',body);
    //.catch(this._errorhandler);
  }
  saveIncm(account:string,category:string,subcatid:string,description:string,amount:string,indate:string,addstatus:string,uid :string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({description:description,amount:amount,subcatid:subcatid,indate:indate,account:account,category:category,addstatus:addstatus,uid : uid});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addincm.php',body);
    //.catch(this._errorhandler);
  }
  saveIncm1(account:string,category:string,subcatid:string,description:string,amount:string,indate:string,addstatus:string,uid :string,filepath:any){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({description:description,amount:amount,subcatid:subcatid,indate:indate,account:account,category:category,addstatus:addstatus,uid : uid,filepath:filepath});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addincm1.php',body);
    //.catch(this._errorhandler);
  }
  saveSubIncome(account:string,category:string,subcatid:string,description:string,amount:string,indate:string,addstatus:string,uid :string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({description:description,amount:amount,subcatid:subcatid,indate:indate,account:account,category:category,addstatus:addstatus,uid : uid});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addsubcatincome.php',body);
    //.catch(this._errorhandler);
  }
  saveSubIncome1(account:string,category:string,subcatid:string,description:string,amount:string,indate:string,addstatus:string,uid :string,filepath:any){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({description:description,amount:amount,subcatid:subcatid,indate:indate,account:account,category:category,addstatus:addstatus,uid : uid,filepath:filepath});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addsubcatincome1.php',body);
    //.catch(this._errorhandler);
  }
  updateincome1(item:any,uid:string,q:Number,filepath:any){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({description:item.description,amount:item.income_amount,tr_date:item.tr_date,account:item.accoun,subcategory:item.subcat_id,category:item.cat_id,income_id:item.income_id,penstatus:item.pendingstatus,uid:uid,q:q,filepath:filepath});
   debugger
    return this.http.post(AppSettings.BASE_URL+'/ws_an_myincome.php',body);
  }
  updateincome(item:any,uid:string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({description:item.description,amount:item.income_amount,tr_date:item.tr_date,account:item.accoun,subcategory:item.subcat_id,category:item.cat_id,income_id:item.income_id,penstatus:item.pendingstatus,uid:uid,q:q});
   debugger
    return this.http.post(AppSettings.BASE_URL+'/ws_an_myincome.php',body);
  }
  updateinc(item:any,uid:string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({description:item.description,amount:item.income_amount,tr_date:item.tr_date,account:item.accoun,subcategory:item.subcat_id,category:item.cat_id,income_id:item.income_id,penstatus:item.pendingstatus,uid:uid,q:q});
   debugger
    return this.http.post(AppSettings.BASE_URL+'/ws_an_myincome.php',body);
  }
  searchAccount(uid:string,accountid :string,penstatus:string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid:uid,accountid: accountid,penstatus:penstatus,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_myincome.php',body);
  }
  searchstatus(uid:string,accountid :string,penstatus:string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid:uid,accountid: accountid,penstatus:penstatus,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_myincome.php',body);
  }
  
 
  deleteProduct(id:string,q:Number){
    let body = JSON.stringify({id : id,q:q});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_myincome.php',body);
  }
  /* _errorhandler(error: Response) {
    //throw new Error("Method not implemented.");
    return Observable.throw(error || 'some error occured on server');
  }*/
}
