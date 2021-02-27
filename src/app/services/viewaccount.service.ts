import { Injectable } from '@angular/core';
import { Http , Response, RequestOptions } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';
import { Expense } from '../expense';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { AppSettings } from './constants';
import { map, catchError } from 'rxjs/operators';
@Injectable()
export class ViewaccountService {
  email : string='';
  //users = [];
  // private _producturl='app/products.json';
  handleError: any;
  headers: any;
   constructor(private http: HttpClient){
    //this.uid= this.loginservice.getIndex();
   
   }

   //baseUrl = 'http://dailyroll.dinkhoo.com/';

 
  getMemberList(accountid:string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: accountid });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_groupslist.php',body);
   
  }

  addUser(name:string,email:string,password:string,uid:string,accountid:string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({name:name,email:email,password:password,uid:uid,accountid: accountid });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addmember.php',body);
  }
}
