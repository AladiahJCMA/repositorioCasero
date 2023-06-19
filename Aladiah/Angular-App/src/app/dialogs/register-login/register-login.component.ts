import { Component, Inject } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { UserService } from 'src/app/services/user.service';
import { User } from 'src/app/types';

@Component({
  selector: 'app-register-login',
  templateUrl: './register-login.component.html',
  styleUrls: ['./register-login.component.css']
})
export class RegisterLoginComponent {
  expression: RegExp = /^(?=.{1,254}$)(?=.{1,64}@)[-!#$%&'*+/0-9=?A-Z^_`a-z{|}~]+(\.[-!#$%&'*+/0-9=?A-Z^_`a-z{|}~]+)*@[A-Za-z0-9]([A-Za-z0-9-]{0,61}[A-Za-z0-9])?(\.[A-Za-z0-9]([A-Za-z0-9-]{0,61}[A-Za-z0-9])?)*$/;
  error = false;
  uniqueUsername = false;
  uniqueEmail = false;

  constructor(
    private userService: UserService,
    public DialogRef: MatDialogRef<RegisterLoginComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) {}

  registerForm = new FormGroup({
    rUsername: new FormControl('', [Validators.required]),
    rEmail: new FormControl('', [Validators.required, Validators.email]),
    rPassword: new FormControl('', [Validators.required])
  });

  loginForm = new FormGroup({
    lUsername: new FormControl('', [Validators.required]),
    lPassword: new FormControl('', [Validators.required]),
    setCookie: new FormControl(true)
  });

  checkUsername (event: any) {
    this.userService.checkUsername(event.target.value)
    .subscribe((e) => this.uniqueUsername = <boolean>e);
  }
  
  checkEmail (event: any) {
    if(this.expression.test(event.target.value)) {
      this.userService.checkEmail(event.target.value)
      .subscribe((e) => this.uniqueEmail = <boolean>e);
    }
  }

  registerUser() {
    let flag: boolean = false;
    const username = this.registerForm.get('rUsername')!.value;
    const email = this.registerForm.get('rEmail')!.value;
    const password = this.registerForm.get('rPassword')!.value;
    if (username && email && password) {
      const rUser: User = {
        id: 0,
        username: username,
        email: email,
        password: password,
        role: 'user',
        premiumExpire: null,
        isPremium: false,
        registerDate: null,
        verified: false
      };

      this.userService.register(rUser)
      .subscribe((e) => {
        flag = <boolean>e;

        if(flag) {
          this.DialogRef.close({ data: false });
        } else {
          this.registerForm.patchValue({
            rUsername: '',
            rEmail: '',
            rPassword: ''
          });
          this.error = true;
        }
      });
    }
    this.error = true;
  }

  login() {
    let flag = false;
    const username = this.loginForm.get('lUsername')!.value;
    const password = this.loginForm.get('lPassword')!.value;
    const setCookie = this.loginForm.get('setCookie')!.value? true : false;
    if (username && password) {
      const lUser: User = {
        id: 0,
        username: username,
        email: '',
        password: password,
        role: 'user',
        premiumExpire: null,
        isPremium: false,
        registerDate: null,
        verified: false
      }
      this.userService.login(lUser, setCookie)
      .subscribe((e) => {
        flag = <string>e !== "false" ;

        if(flag) {
          this.DialogRef
          .close({ data: { user: lUser, cookie: <string>e } });
        }
      });
    }
  }

  close() {
    this.DialogRef.close({ data: false });
  }
}
