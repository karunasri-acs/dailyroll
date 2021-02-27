import { Injectable , OnInit} from '@angular/core';
import { Http , Response, RequestOptions } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';
import { Expense } from '../expense';
import { AppSettings } from './constants';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';

import { map, catchError } from 'rxjs/operators';
@Injectable()
export class AccountService {
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
  getAccounts(uid : string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  getCurrencyList(uid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid ,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_get_currency_dropdown.php',body);
  }
  getexpensesacc(accountid : string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: accountid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accountall.php',body);
     
  }
  getincomeacc(accountid : string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: accountid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accountall.php',body);
     
  }
  getArchieveAccounts(uid : string,q:Number) {
    debugger;
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  viewAccounts(aid : Number,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: aid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  accountName(aid : Number,uid:string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: aid,uid:uid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  inactiveacc(item:any,userid : string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({accountid:item.account_id,userid: userid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  activeacc(item:any,userid : string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({accountid:item.account_id,userid: userid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
   
  addcontact(contactname:any,contactemail : string,contactaddress:any,contactphone:any,selectaccountid:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({contactname:contactname,contactemail:contactemail,contactaddress:contactaddress,contactphone:contactphone,selectaccountid:selectaccountid,q:q });
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
   
  admin(list:any,accountid:Number,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid:list.add_user_id,accountid:accountid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  changeusertype(list:any,accountid:Number,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid:list.add_user_id,usertype:list.usertype,accountid:accountid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  active(list:any,accountid:Number,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid:list.add_user_id,accountid:accountid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  inactive(accountid:Number,list:any,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({accountid:accountid,userid:list.add_user_id,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  updateAccount(accountname:string,accountid:Number,currency:String,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({accountname:accountname, accountid: accountid,currency :currency,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  getAddAccounts(accountname : string,currency : string, uid:string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountname: accountname,currency:currency,uid:uid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
  }

  addMember(accountid : Number,memberemail:string,membername:string,memberphoneno:string,selectusertype:string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: accountid,memberemail:memberemail,membername:membername,memberphoneno:memberphoneno,selectusertype:selectusertype,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  viewAccountList(aid : Number,memberid :Number,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: aid,memberid:memberid ,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accounts.php',body);
     
  }
  saveAccount(uid :string,account:string,){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({uid : uid,account :account});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_addaccounts.php',body);
    //.catch(this._errorhandler);
  }
  updateProd(item:any){
    let body = JSON.stringify({account:item.accountname,id : item.account_id});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accountupdate.php',body);
  }
  archiveaccount(item:any){
    let body = JSON.stringify({id : item.account_id});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_archiveaccount.php',body);
  }
  unarchive(id :string){
    let body = JSON.stringify({id : id});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_unarchiveaccount.php',body);
  }
  getUnarchiveList(uid : string) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid: uid });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_unarchivelist.php',body);
     
  }
}
