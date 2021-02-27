import { Component, OnInit } from '@angular/core';
import {DomSanitizer,SafeResourceUrl} from '@angular/platform-browser';
@Component({
  selector: 'app-starter-slider',
  templateUrl: './starter-slider.component.html',
  styleUrls: ['./starter-slider.component.css']
})
export class StarterSliderComponent implements OnInit {
  urlif:any;

  constructor( private sanitizer: DomSanitizer) { }

  ngOnInit() {
    this.urlif= this.sanitizer.bypassSecurityTrustResourceUrl('https://www.dailyroll.org/dailyroll-api/apptour.php')
  
  }

}
