import { Component, AfterViewInit } from '@angular/core';

declare global {
  interface Window { adsbygoogle: any; }
}
declare var adsbygoogle: any[];
@Component({
  selector: 'app-expads',
  templateUrl: './expads.component.html',
  styleUrls: ['./expads.component.css']
})
export class ExpadsComponent implements AfterViewInit {

  constructor() { }

  ngAfterViewInit() {
    try {
      (adsbygoogle = window.adsbygoogle || []).push({});
    } catch (e) {}
  }

}
