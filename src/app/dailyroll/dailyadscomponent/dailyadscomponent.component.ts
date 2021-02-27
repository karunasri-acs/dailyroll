import { Component, AfterViewInit } from '@angular/core';

declare global {
  interface Window { adsbygoogle: any; }
}
declare var adsbygoogle: any[];
@Component({
  selector: 'app-dailyadscomponent',
  templateUrl: './dailyadscomponent.component.html',
  styleUrls: ['./dailyadscomponent.component.css']
})
export class Dailyadscomponent implements AfterViewInit  {

  constructor() { }

  ngAfterViewInit() {
    try {
      (adsbygoogle = window.adsbygoogle || []).push({});
    } catch (e) {}
  }
}


