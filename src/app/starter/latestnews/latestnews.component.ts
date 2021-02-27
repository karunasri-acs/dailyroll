import { Component,OnInit } from '@angular/core';
import { Router, ActivatedRoute , NavigationExtras } from '@angular/router';
import { LoginServiceService } from '../../services/login-service.service';


@Component({
  selector: 'app-latestnews',
  templateUrl: './latestnews.component.html',
  styleUrls: ['./latestnews.component.css']
})
export class LatestnewsComponent implements OnInit {
  newsList:any;
  constructor(private router:Router,private expenseservice:LoginServiceService){}
 

  ngOnInit() {
    this.getnews();
  }
getnews(){
  this.expenseservice.getnews().subscribe(
    res => {
      this.newsList = res;
     //this.userservice.alertMsg(res);
     }
   
  );



}
viewadd(data:any){
  //this.userservice.alertMsg(data.id);

  let navigationExtras: NavigationExtras = {
    queryParams: {
        "id": data.id
    }
  }

  this.router.navigate(['linkednews'],navigationExtras);
 }
}
