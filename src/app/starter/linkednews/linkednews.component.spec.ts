import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LinkednewsComponent } from './linkednews.component';

describe('LinkednewsComponent', () => {
  let component: LinkednewsComponent;
  let fixture: ComponentFixture<LinkednewsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LinkednewsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LinkednewsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
