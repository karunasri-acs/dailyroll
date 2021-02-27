import { Injectable } from '@angular/core';
import { Route, PreloadingStrategy } from '@angular/router';
import { Observable } from 'rxjs';
import { of } from 'rxjs/observable/of';

@Injectable()
export class SelectiveStrategy implements PreloadingStrategy {

  preload(route: Route, load: Function): Observable<any> {
    if (route.data && route.data['preload']) {
      return load();
    }
    return of(null);
  }
}
