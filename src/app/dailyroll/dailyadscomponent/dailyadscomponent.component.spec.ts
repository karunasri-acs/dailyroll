import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { Dailyadscomponent } from './dailyadscomponent.component';

describe('DailyadscomponentComponent', () => {
  let component: Dailyadscomponent;
  let fixture: ComponentFixture<Dailyadscomponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ Dailyadscomponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(Dailyadscomponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
