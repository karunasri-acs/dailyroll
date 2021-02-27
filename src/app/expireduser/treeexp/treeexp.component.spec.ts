import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TreeexpComponent } from './treeexp.component';

describe('TreeexpComponent', () => {
  let component: TreeexpComponent;
  let fixture: ComponentFixture<TreeexpComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TreeexpComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TreeexpComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
