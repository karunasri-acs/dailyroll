import { Component, OnInit,ElementRef } from '@angular/core';
import { ProfileService } from '../../services/profile.service';
import { Router, ActivatedRoute } from '@angular/router';
import swal from 'sweetalert';
@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
  uid:string='';
  firstName:string;
  lastName : string;
  country :string;
  address : string;
  phone :string;
  email :string;
  name:any;
  photo:any;
  filepath:string;
  profiles :any;
  profileimage :string;
  errorMessage:string="";
  error:boolean=false;
  successMessage:string="";
  success:boolean=false;
  details: any;
  list:any;
  profRes: any;
  constructor(private router:Router, private myexpense:ProfileService, private elem:ElementRef) {
    
   }
  
  ngOnInit() {
    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
      // console.log(this.uid);
    } 
    this.getprofiles();
  }
  public saveprofile(post): void{
    let files= this.elem.nativeElement.querySelector('#fileToUpload').files;
   debugger;
   this.list = post;
   if(files.length > 0){
    let formdata = new FormData();
    let file = files[0];
    let filename= this.uid+"-"+file.name;
   // let filename= this.getfilename(this.uid);
    debugger;
    formdata.append('fileToUpload',file,filename);
    this.myexpense.uploadImage(formdata).subscribe
    (res => this.updateprofile(res));
   }else{
     this.updateprofile1();
   }
  }
  getprofiles(){
  this.myexpense.getDetails(this.uid).subscribe(data=>{
    this.details = data;
   // this.userservice.alertMsg(data)
   for (let key of this.details) {
    console.log("object:", key);
    this.name = key.name;
    this.photo = key.photo;
    sessionStorage.setItem('name',this.name);
    sessionStorage.setItem('photo',this.photo);
   }
     

  });
}
  public updateprofile(data:any):void{
    //let filename =this.files.filename;
    this.profiles = data;
    let photo = this.list.photo;
    sessionStorage.setItem("profile", JSON.stringify(photo));
    this.filepath = data.filename;
    //console.log(this.filepath)
    debugger;
    this.myexpense.saveprof(this.list.firstName,this.list.lastName,this.list.email,this.list.address,this.list.country,this.list.phone,this.uid,this.filepath).subscribe(
      success=>{
      this.profRes =success
      swal(success);
      this.refreshList();
    },
    error=>{
      this.error=!this.error;
      this.errorMessage="Unexpected Error Occured";
    });
    
    }
    //this.refreshList();
    public  refreshList(){
      this.getprofiles();
    }
    public updateprofile1():void{
      //let filename =this.files.filename;
    
      //console.log(this.filepath)
      debugger;
      
       this.myexpense.saveprof1(this.list.firstName,this.list.lastName,this.list.email,this.list.address,this.list.country,this.list.phone,this.uid)
        .subscribe(success=>{
        this.success=!this.success;
        this.error=false;
        this.successMessage="Profile Updated";
        swal(this.successMessage);
      },
      error=>{
        this.error=!this.error;
        this.errorMessage="Unexpected Error Occured";
      });
    this.refreshList();
      }
}
