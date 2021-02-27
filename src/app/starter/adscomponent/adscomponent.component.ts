import { Component, AfterViewInit } from '@angular/core';

declare global {
  interface Window { adsbygoogle: any; }
}
declare var adsbygoogle: any[];
@Component({
  selector: 'app-adscomponent',
  templateUrl: './adscomponent.component.html',
  styleUrls: ['./adscomponent.component.css']
})
export class AdscomponentComponent implements AfterViewInit  {

  constructor() { }

  ngAfterViewInit() {
    try {
      (adsbygoogle = window.adsbygoogle || []).push({});
    } catch (e) {}
  }
}


