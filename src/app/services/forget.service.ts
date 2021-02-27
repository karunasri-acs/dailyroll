import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { map, catchError } from 'rxjs/operators';
import { Http, Response, Headers } from "@angular/http";
import { Observable } from "rxjs/Observable";
import 'rxjs/add/operator/map';
import "rxjs/add/operator/catch";
import "rxjs/add/observable/throw";
import { User } from '../user';
import { AppSettings } from './constants';
//import { throwError } from 'rxjs/internal/observable/throwError';
@Injectable()
export class ForgetService {
  constructor(private http: HttpClient){}
 
  //RestUrl='http://dailyroll.dinkhoo.com/';
 
  forgetpassword(email :string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ email: email});
    debugger;

    return this.http.post(AppSettings.BASE_URL+'/ws_an_forgetpassword.php', body)
  }
}
