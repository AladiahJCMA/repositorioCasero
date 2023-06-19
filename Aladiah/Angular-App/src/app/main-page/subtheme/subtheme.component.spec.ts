import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SubthemeComponent } from './subtheme.component';

describe('SubthemeComponent', () => {
  let component: SubthemeComponent;
  let fixture: ComponentFixture<SubthemeComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [SubthemeComponent]
    });
    fixture = TestBed.createComponent(SubthemeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
