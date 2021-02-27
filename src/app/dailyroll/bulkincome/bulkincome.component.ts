import { Component, OnInit,ElementRef } from '@angular/core';
import { MyexpenseService } from '../../services/myexpense.service';
import { Router, ActivatedRoute,NavigationExtras } from '@angular/router';
//import { Select } from '@mobiscroll/angular/src/js/classes/select';
import { NgForm, FormGroup, FormArray, FormBuilder } from '@angular/forms';
import { Category } from '../../expireduser/category/category';
import {DomSanitizer,SafeResourceUrl} from '@angular/platform-browser';
import { AppSettings } from '../../services/constants';
@Component({
  selector: 'app-bulkincome',
  templateUrl: './bulkincome.component.html',
  styleUrls: ['./bulkincome.component.css']
})
export class BulkincomeComponent implements OnInit {

  uid:any;
 
  urlif: SafeResourceUrl;

  constructor(private sanitizer: DomSanitizer) { 
 
  }
 ngOnInit() {

    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
      // console.log(this.uid);
     
     }
     this.urlif= this.sanitizer.bypassSecurityTrustResourceUrl(AppSettings.BASE_URL+'/ws_an_addbulkincome.php?uid='+this.uid)

  }
  
}
