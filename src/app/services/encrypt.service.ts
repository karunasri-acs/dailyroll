import { Injectable } from '@angular/core';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';
import { AppSettings } from './constants';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { EmailValidator } from '@angular/forms';
@Injectable()
export class ENCRYPTSERVICE {
 
   private _producturl='app/products.json';
  handleError: any;
  headers: any;
   constructor(private http: HttpClient){}
   
   
   encryptdata(stringvalue:any) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ stringvalue:stringvalue});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_encrypt.php',body);
     
  }
  encryptregdata(firstname:any,email:any,phone:any) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({firstname:firstname,email:email,phone:phone});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_totalencrypt.php',body);
     
  }
   decryptdata(stringvalue:any) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ stringvalue:stringvalue});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_decrypt.php',body);
     
  }
   
}
