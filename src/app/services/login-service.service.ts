import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { map, catchError } from 'rxjs/operators';
import { Http, Response, Headers } from "@angular/http";
import { Observable } from "rxjs/Observable";
import 'rxjs/add/operator/map';
import "rxjs/add/operator/catch";
import "rxjs/add/observable/throw";
import { AppSettings } from './constants';
import { User } from '../user';
@Injectable(

)
export class LoginServiceService {
  uid:string="";
  users: User[];
  isloggedin:boolean=false;
  handleError: any;
  constructor(private http: HttpClient){}
 
  setLoggedin(logged){
     this.isloggedin=logged;
   }
  RestUrl='http://dailyroll.dinkhoo.com/';
  ValidateUser(username:string,password:string){
      var headers= new Headers();
      headers.append('Content-Type','application/X-www-form=urlencoded');
      let body = JSON.stringify({ username: username, password: password });
      debugger;

      return this.http.post(AppSettings.BASE_URL+'/ws_an_login.php', body);/*.pipe(
        map((res) => {
          this.users=res['data'];
          return this.users;
      }),
      catchError(this.handleError));*/
    }
    
    setIndex(uid){
      this.uid=uid;
    }
    getIndex(){
      return this.uid;
    }

    getAuth(userid:string,q:number) {
      var headers= new Headers();
      headers.append('Content-Type','application/X-www-form=urlencoded');
      let body = JSON.stringify({ userid: userid,q:q });
      debugger;

      return this.http.post(AppSettings.BASE_URL+'/ws_an_device_confirm.php', body);
    }
    verifyCode(authcode:string,userid:string,q:number) {
      var headers= new Headers();
      headers.append('Content-Type','application/X-www-form=urlencoded');
      let body = JSON.stringify({ authcode:authcode,userid: userid,q:q });
      debugger;

      return this.http.post(AppSettings.BASE_URL+'/ws_an_device_confirm.php', body);
    }
    getuserdetails(userid:string){
      var headers= new Headers();
      headers.append('Content-Type','application/X-www-form=urlencoded');
      let body = JSON.stringify({ userid: userid });
      debugger;
      return this.http.post(AppSettings.BASE_URL+'/ws_an_sociallogin.php', body);
    }
    sendrequest(email:string,q:number) {
      var headers= new Headers();
      headers.append('Content-Type','application/X-www-form=urlencoded');
      let body = JSON.stringify({ email: email,q:q });
      debugger;

      return this.http.post(AppSettings.BASE_URL+'/ws_an_device_confirm.php', body);
    }
    getnews() {
      var headers= new Headers();
      headers.append('Content-Type','application/X-www-form=urlencoded');
      let body = JSON.stringify({});
      debugger;

      return this.http.post(AppSettings.BASE_URL+'/ws_an_getnews.php', body);
    }
    viewnews(id:any) {
      var headers= new Headers();
      headers.append('Content-Type','application/X-www-form=urlencoded');
      let body = JSON.stringify({id:id});
      debugger;

      return this.http.post(AppSettings.BASE_URL+'/ws_an_viewnews.php', body);
    }

  }
  
              //console.log(login);
 


