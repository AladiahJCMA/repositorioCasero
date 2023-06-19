import { Component, Inject } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { SharedDataService } from 'src/app/services/shared-data.service';
import { UserService } from 'src/app/services/user.service';
import { User } from 'src/app/types';

@Component({
  selector: 'app-user-data',
  templateUrl: './user-data.component.html',
  styleUrls: ['./user-data.component.css']
})
export class UserDataComponent {
  expression: RegExp = /^(?=.{1,254}$)(?=.{1,64}@)[-!#$%&'*+/0-9=?A-Z^_`a-z{|}~]+(\.[-!#$%&'*+/0-9=?A-Z^_`a-z{|}~]+)*@[A-Za-z0-9]([A-Za-z0-9-]{0,61}[A-Za-z0-9])?(\.[A-Za-z0-9]([A-Za-z0-9-]{0,61}[A-Za-z0-9])?)*$/;
  user: User | null = null;
  uniqueUsername = false;
  uniqueEmail = false;
  error: boolean = false;

  constructor(
    private userService: UserService,
    private sharedData: SharedDataService,
    public DialogRef: MatDialogRef<UserDataComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) {}

  ngOnInit() {
    this.sharedData.data
    .subscribe((e) => {
      this.user = <User>e;
      this.editForm.patchValue({
        username: this.user.username,
        email: this.user.email,
        password: this.user.password,
      })
    });
  }

  editForm = new FormGroup({
    username: new FormControl('', [Validators.required]),
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required])
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

  updateUser() {
    let flag: boolean = false;
    const nUsername = this.editForm.get('username')!.value;
    const nEmail = this.editForm.get('email')!.value;
    const nPassword = this.editForm.get('password')!.value;
    if ( nUsername && nEmail && nPassword) {
      const rUser: User = {
        id: this.user!.id,
        username: nUsername,
        email: nEmail,
        password: nPassword,
        role: 'user',
        premiumExpire: null,
        isPremium: false,
        registerDate: null,
        verified: false
      };

      this.userService.editUser(rUser)
      .subscribe((e) => {
        flag = <boolean>e;

        if(flag) {
          this.DialogRef.close({ data: false });
        } else {
          this.error = true;
        }
      })
    }
  }

  closeSession() {
    this.sharedData.data.next(null);
    this.DialogRef.close({ data: true });
  }

  close() {
    this.DialogRef.close({ data: false });
  }
}
