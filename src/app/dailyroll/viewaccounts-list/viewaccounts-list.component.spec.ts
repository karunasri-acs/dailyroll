import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ViewaccountsListComponent } from './viewaccounts-list.component';

describe('ViewaccountsListComponent', () => {
  let component: ViewaccountsListComponent;
  let fixture: ComponentFixture<ViewaccountsListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ViewaccountsListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ViewaccountsListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
