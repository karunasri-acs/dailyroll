import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { AppSettings } from './constants';
import swal from 'sweetalert';
@Injectable()
export class UserServiceService {
  authode: string;
  msg: any;

  constructor(private http: HttpClient) {}
  isLoggedIn(): boolean {
    if(sessionStorage.getItem('uid')!= null){
      return true;
    }else{
      return false;
    }
  
  }
  getAuthCode(uid:number,q:number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid,q:q});
    debugger;

    return this.http.post(AppSettings.BASE_URL+'/ws_an_getAuthCode.php', body);
  }
  getgooglekey(uid:number,q:number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid,q:q});
    debugger;

    return this.http.post(AppSettings.BASE_URL+'/ws_an_getAuthCode.php', body);
  }
  alertMsg(message:string){
    this.msg= swal({
    title: "e-Medicall",
    text:message
    })
    return this.msg;
  }
}
