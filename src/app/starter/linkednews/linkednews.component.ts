import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, NavigationExtras } from '@angular/router';
import { LoginServiceService } from '../../services/login-service.service';
import { DomSanitizer } from '@angular/platform-browser';

@Component({
  selector: 'app-linkednews',
  templateUrl: './linkednews.component.html',
  styleUrls: ['./linkednews.component.css']
})
export class LinkednewsComponent implements OnInit {
  myTable:boolean=false;
  sub:any;
  id:any;
  newsList:any;
  urlif:any;
  link:any;
  constructor(private router:Router,private myexpense:LoginServiceService,private activatedRoute: ActivatedRoute,private sanitizer: DomSanitizer) { }


  ngOnInit() {
    this.sub = this.activatedRoute.queryParams.subscribe(params => {
      debugger;
      this.id = params["id"];
    // this.userservice.alertMsg(this.id);
    });
    this.getnews();
  }
getnews(){

  this.myexpense.viewnews(this.id).subscribe(
    res => {
      this.newsList = res;
     //this.userservice.alertMsg(res);
     for (let key of this.newsList) {
      console.log("object:", key);
        
        this.link = key.link;
      // this.userservice.alertMsg(this.uid);
      }
   
     this.urlif= this.sanitizer.bypassSecurityTrustResourceUrl(this.link)

  this.myTable=true;
     }
   
  );


}
}
