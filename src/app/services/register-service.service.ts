import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { Http, Response, Headers } from "@angular/http";
import { Observable } from "rxjs/Observable";
import 'rxjs/add/operator/map';
import "rxjs/add/operator/catch";
import "rxjs/add/observable/throw";
import { AppSettings } from './constants';
@Injectable()
export class RegisterServiceService {

  constructor(private http: HttpClient){}

  createUser(firstname:string,email:string,password:string,phone:string){
    debugger; 
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    let body = JSON.stringify({ firstname: firstname,email:email, password: password,phone:phone });
    return this.http.post(AppSettings.BASE_URL+'/ws_an_register.php', body);
  }
  encryptregdata(firstname:string,phone:string){
    debugger; 
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    let body = JSON.stringify({ firstname: firstname, phone:phone });
    return this.http.post(AppSettings.BASE_URL+'/ws_an_totalencrypt.php', body);
  }
 
}
