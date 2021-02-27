import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { expireduserComponent } from './expireduser.component';

describe('DailyrollComponent', () => {
  let component: expireduserComponent;
  let fixture: ComponentFixture< expireduserComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ expireduserComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent( expireduserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
