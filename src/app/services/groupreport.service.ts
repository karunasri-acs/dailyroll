import { Injectable, OnInit } from '@angular/core';
import { Http , Response, RequestOptions } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';
import { Expense } from '../expense';
import { AppSettings } from './constants';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';

import { map, catchError } from 'rxjs/operators';

@Injectable()
export class GroupreportService {
  email : string='';
  //users = [];
   private _producturl='app/products.json';
  handleError: any;
  headers: any;
   constructor(private http: HttpClient){
    //this.uid= this.loginservice.getIndex();
   
   }
   //baseUrl = 'http://dailyroll.dinkhoo.com/';
   expenses=[];
  

   getSearchData(type :string,accountid: string, fromdate : string,todate : string, catid: string, subcatid : string,memid : string,penstatus:string) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({type : type,accountid : accountid, fromdate : fromdate, todate: todate,catid : catid, subcatid : subcatid, memid: memid,pensttus:penstatus });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getsearchreports.php',body);
     
  }
   getSearchbalData(type :string,accountid: string,status:StringConstructor) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({type : type,accountid : accountid,status:status });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_balancesheet.php',body);
     
  }
  getSubCategoryList(catid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ catid: catid,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getdropdown.php',body);
  }
  

  getCategoryList(accountid :string,type:string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: accountid,type:type,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getdropdown.php',body);
  }
  getAccountsList(uid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid ,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getdropdown.php',body);
  }
  getMemberList(accountid:string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: accountid});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getmember.php',body);
  }
  checkadmin(accountid:string,uid:string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: accountid,uid:uid});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_checkadmin.php',body);
  }
  freezeaccount(accountid:string,todate:string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: accountid,todate:todate});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_freezeacc.php',body);
  }
}