/* Angular imports */
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { AppRoutingModule } from './app-routing.module';
import { MatDialogModule } from '@angular/material/dialog';
import { CookieService } from 'ngx-cookie-service';
import { MatTreeModule } from '@angular/material/tree';
import { MatIconModule } from '@angular/material/icon';
import { MatTabsModule } from '@angular/material/tabs';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { MatSelectModule } from '@angular/material/select';

/* App imports */
import { AppComponent } from './app.component';
import { NavBarComponent } from './nav-bar/nav-bar.component';
import { TopBarComponent } from './top-bar/top-bar.component';
import { MainPageComponent } from './main-page/main-page.component';
import { RegisterLoginComponent } from './dialogs/register-login/register-login.component';
import { SubthemeComponent } from './main-page/subtheme/subtheme.component';
import { PostComponent } from './main-page/post/post.component';
import { AboutMeComponent } from './main-page/about-me/about-me.component';
import { UserDataComponent } from './dialogs/user-data/user-data.component';
import { ConfigDialogComponent } from './dialogs/config-dialog/config-dialog.component';
import { NewPostComponent } from './dialogs/new-post/new-post.component';

@NgModule({
  declarations: [
    AppComponent,
    NavBarComponent,
    TopBarComponent,
    MainPageComponent,
    RegisterLoginComponent,
    SubthemeComponent,
    PostComponent,
    AboutMeComponent,
    UserDataComponent,
    ConfigDialogComponent,
    NewPostComponent
  ], 
  imports: [
    BrowserModule,
    HttpClientModule,
    ReactiveFormsModule,
    AppRoutingModule,
    MatDialogModule,
    MatTreeModule,
    MatIconModule,
    MatTabsModule,
    MatFormFieldModule,
    MatInputModule,
    BrowserModule,
    BrowserAnimationsModule,
    MatCheckboxModule,
    MatSelectModule
  ], 
  bootstrap: [ AppComponent ],
  providers: [ CookieService ],
})
export class AppModule { }


/*
Copyright Google LLC. All Rights Reserved.
Use of this source code is governed by an MIT-style license that
can be found in the LICENSE file at https://angular.io/license
*/