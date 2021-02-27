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
import { LoginServiceService } from './login-service.service';
@Injectable()
export class ProfileService {

  uid:string;
  constructor(private loginservice:LoginServiceService,private http:HttpClient) {
    this.uid= this.loginservice.getIndex();
   }

  getDetails(uid: string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({uid : uid});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getprofile.php',body);
    }

  uploadImage(formdata:any){
    var headers= new Headers();
    headers.append('enctype', 'multipart/form-data');
    headers.append('Accept', 'application/json');
    //let options = new RequestOptions({ headers: this.headers });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_profileupload.php',formdata);
  }
  saveprof(name:string,lname:string,email:string,address:string,country:string,phone:string,uid :string,filename:string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({name:name,lname:lname,email:email,address:address,country:country,phone :phone,uid : uid,filename :filename});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_profile.php',body);
    //.catch(this._errorhandler);
  }
  saveprof1(name:string,lname:string,email:string,address:string,country:string,phone:string,uid :string){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    debugger;
    //let options = new RequestOptions({ header: headers });
    let body = JSON.stringify({name:name,lname:lname,email:email,address:address,country:country,phone :phone,uid : uid});
    return this.http.post(AppSettings.BASE_URL+'/ws_an_updateprofile.php',body);
    //.catch(this._errorhandler);
  }
}
