import { Component, OnInit,ElementRef } from '@angular/core';
import { MyexpenseService } from '../../services/myexpense.service';
import { Router, ActivatedRoute,NavigationExtras } from '@angular/router';
//import { Select } from '@mobiscroll/angular/src/js/classes/select';
import {DomSanitizer,SafeResourceUrl} from '@angular/platform-browser';
import { Category } from '../../expireduser/category/category';
import { AppSettings } from '../../services/constants';
@Component({
  selector: 'app-bulkexpenses',
  templateUrl: './bulkexpenses.component.html',
  styleUrls: ['./bulkexpenses.component.css']
})
export class BulkexpensesComponent implements OnInit {
  accountslist:any;
  uid:any;
  accountid ='select';
  urlif: SafeResourceUrl;
  categorylist:any;
  entries:any;
  catid:any;
  totalentries:any;
  subcategorylist:any;
  error:any;
  options:any;
  date:any;
  constructor(private sanitizer: DomSanitizer) { 
 
  }
 
  ngOnInit() {

    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
      // console.log(this.uid);
   
     }
     this.urlif= this.sanitizer.bypassSecurityTrustResourceUrl(AppSettings.BASE_URL+'/ws_an_addbulkexpenses.php?uid='+this.uid)

  }
  

}
