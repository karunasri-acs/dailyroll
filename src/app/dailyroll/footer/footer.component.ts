import { Component, OnInit } from '@angular/core';
import { DashboardService } from '../../services/dashboard.service';
@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.css']
})
export class FooterComponent implements OnInit {
  datares:any;
  futureyears:any;
   presents:any;
   versions:any;
   projectname:any;
  constructor( private count:DashboardService) { }

  ngOnInit() {
    this.getfooterdata();
  }
  getfooterdata(){
    debugger;
         this.projectname='DailyRoll-ANG';
    this.count.getfooter(this.projectname).subscribe(
      res => {
        this.datares = res;
        for(let item of this.datares){
          var aid = item.version
          var present = item.present
          var futureyear = item.futureyear

        }
       
     this.futureyears = futureyear;
     this.presents =present;
     this.versions=aid;
       // this.userservice.alertMsg(this.accountid);
      
       },
      (err) => {
       
      }
    );


  }
}
