import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DailyrollComponent } from './dailyroll.component';

describe('DailyrollComponent', () => {
  let component: DailyrollComponent;
  let fixture: ComponentFixture<DailyrollComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DailyrollComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DailyrollComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
