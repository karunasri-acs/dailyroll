import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { GroupreportsComponent } from './groupreports.component';

describe('GroupreportsComponent', () => {
  let component: GroupreportsComponent;
  let fixture: ComponentFixture<GroupreportsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ GroupreportsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(GroupreportsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
