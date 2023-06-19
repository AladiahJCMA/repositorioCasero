import { Component, EventEmitter } from '@angular/core';
import { PostService } from './services/post.service';
import { UserService } from './services/user.service';
import { User, Post, Theme, Subtheme } from './types';
import { ThemesService } from './services/themes.service';
import { CookieService } from 'ngx-cookie-service';
import { MatDialog } from '@angular/material/dialog';
import { RegisterLoginComponent } from './dialogs/register-login/register-login.component';
import { SharedDataService } from './services/shared-data.service';
import { UserDataComponent } from './dialogs/user-data/user-data.component';
import { ConfigDialogComponent } from './dialogs/config-dialog/config-dialog.component';
import { NewPostComponent } from './dialogs/new-post/new-post.component';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'Aladiah';
  user: User | null = null;


  constructor(
    private postService: PostService, 
    private userService: UserService,
    private themesService: ThemesService,
    private cookieService: CookieService,
    private sharedData: SharedDataService,
    public dialog: MatDialog
    ) {}

  ngOnInit() {
    if(this.cookieService.check('loginCookie')) {
      console.log('login cookie');
      const cookie = this.cookieService.get('loginCookie');
      const clReply = this.userService.cookieLogin(cookie);
      clReply.subscribe((e) => {
        console.log(e);
        this.user = <User>e
        this.sharedData.data.next(this.user);
      });
    } else {
      console.log('login cookie is not set');
    }
  }

  openRegisterLoginDialog = (args: any): void => {
    let DialogRef = this.dialog.open(RegisterLoginComponent, {
      width: 'auto',
      height : 'auto',
      maxWidth: '60vw',
      maxHeight: '60vh',
    }).afterClosed().subscribe((result) => {
      if(result !== undefined && result.data) {
        this.user = result.data.user;
        this.sharedData.data.next(this.user);
        if(result.data.cookie !== "true") {
          console.log(result.data.cookie);
          this.cookieService.set('loginCookie', result.data.cookie, 7);
          console.log(this.cookieService.get('loginCookie'));
          // Pues por algun motivo editThisCookie muestra %250 en lugar de %0 para el id de root, pero el get funciona
        }
      }
    });
  }

  openDetailsDialog = (args: any): void => {
    let DialogRef = this.dialog.open(UserDataComponent, {
      width: 'auto',
      height : 'auto',
      maxWidth: '60vw',
      maxHeight: '60vh',
    }).afterClosed().subscribe((result) => {
      if(result.data) {
        this.user = null;
        this.cookieService.set('loginCookie', '', -1);
      }
    })
  }

  configDialog = (args: any): void => {
    let DialogRef = this.dialog.open(ConfigDialogComponent, {
      width: 'auto',
      height : 'auto',
      maxWidth: '60vw',
      maxHeight: '60vh',

    }).afterClosed().subscribe((result) => {
      if(result.data) {
        this.ngOnInit();
      }
    });
  }

  openNewPostDialog = (args: any): void => {
    let DialogRef = this.dialog.open(NewPostComponent, {
      width: 'auto',
      height : 'auto',
      maxWidth: '60vw',
      maxHeight: '60vh',
    }).afterClosed().subscribe((result) => {
      if(result.data) {
        this.ngOnInit();
      }
    });
  }

  parentEventEmitter: EventEmitter<any> = new EventEmitter();

  lunchNukes() {
    this.parentEventEmitter.emit(this.openRegisterLoginDialog);
  }
}


/*
Copyright Google LLC. All Rights Reserved.
Use of this source code is governed by an MIT-style license that
can be found in the LICENSE file at https://angular.io/license
*/