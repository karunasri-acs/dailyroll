import { Injectable } from '@angular/core';
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
export class DashboardService {

  constructor(private http: HttpClient) { }
  
   emergency=[];
   getaccountcount(uid : string) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid: uid });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_accountcount.php',body);
      
  }
  getExpcount(uid : string) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid: uid });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getexpensecount.php',body);
    
  }
  getAccountsList(uid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid ,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_getdropdown.php',body);
  }
  getyear(uid :string,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ uid: uid ,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/getexpensetree.php',body);
  }
  getexpensestree(accountid :string,penstatus:any,selectyear:any,q:Number){
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ accountid: accountid ,penstatus:penstatus,selectyear:selectyear,q:q});
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/getexpensetree.php',body);
  }
  getBarChart(uid : string,acc:Number,periodtype:string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid: uid,accountid:acc,periodtype:periodtype,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_dashboard.php',body);
     
  }
  getfooter(projectname:string) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ projectname:projectname });
    debugger;
    return this.http.post('https://support.jwtechinc.com/ws_an_footer.php',body);
     
  }
 
  getincome(uid : string) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid: uid });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_incomecount.php',body);
     
  }
  getPieChart(uid : string,acc:Number,periodtype:string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid: uid,accountid:acc,periodtype:periodtype,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_dashboard.php',body);
     
  }
  getColChart(uid : string,q:Number) {
    var headers= new Headers();
    headers.append('Content-Type','application/X-www-form=urlencoded');
    let body = JSON.stringify({ userid: uid,q:q });
    debugger;
    return this.http.post(AppSettings.BASE_URL+'/ws_an_dashboard.php',body);
     
  }
  
  
}



   