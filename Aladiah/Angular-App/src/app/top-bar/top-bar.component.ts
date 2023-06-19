import { Component, EventEmitter, Input, OnDestroy, OnInit } from '@angular/core';
import { RegisterLoginComponent } from '../dialogs/register-login/register-login.component';
import { MatDialog } from '@angular/material/dialog';
import { User } from '../types';
import { SharedDataService } from '../services/shared-data.service';

@Component({
  selector: 'app-top-bar',
  templateUrl: './top-bar.component.html',
  styleUrls: ['./top-bar.component.css']
})

export class TopBarComponent {
  user: User | null = null;

  constructor(
    private sharedData: SharedDataService
  ) {}
  ngOnInit() {
    this.sharedData.data.subscribe((data: User | null) => {
      this.user = data;
      console.log(this.user);
    });
  }

  @Input() openRegisterLoginDialog?: (args: void) => void
  @Input() openDetailsDialog?: (args: void) => void
  @Input() configDialog?: (args: void) => void
  @Input() openNewPostDialog?: (args: void) => void
}
