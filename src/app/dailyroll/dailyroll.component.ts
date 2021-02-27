import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-dailyroll',
  templateUrl: './dailyroll.component.html',
  styleUrls: ['./dailyroll.component.css']
})
export class DailyrollComponent implements OnInit {


  bodyClasses = 'skin-blue sidebar-mini';
  body: HTMLBodyElement = document.getElementsByTagName('body')[0];

  constructor() { }

  ngOnInit() {
    // add the the body classes
    this.body.classList.add('skin-blue');
    this.body.classList.add('sidebar-mini');
  }

   ngOnDestroy() {
    // remove the the body classes
    this.body.classList.remove('skin-blue');
    this.body.classList.remove('sidebar-mini');
  }

}
