import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { User } from '../types';
import { url } from './config'; 

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private http: HttpClient) { }

  getUsers() {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
      }),
    };

    return this.http.get(`${url}/users`, httpOptions);
  }

  getUser(idUser: number) {
    return this.http.get(`${url}/user/${idUser}`);
  }

  register(nUser: User) {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
      }),
    };

    return this.http.post(`${url}/user`, nUser, httpOptions);
  }

  login (lUser: User, setCookie: boolean) {
    return this.http.post(`${url}/user/login/${setCookie}`, lUser);
  }

  cookieLogin(cookie: string) {
    return this.http.post(`${url}/user/cookieLogin`, cookie);
  }

  verify (vUser: User) {
    return this.http.post(`${url}/user/verify`, vUser);
  }

  editUser (eUser: User) {
    return this.http.put(`${url}/user`, eUser);
  }

  // NOT SECURE, NOT IMPLEMENTED
  deleteUser(idUser: number) {
    return this.http.delete(`${url}/user/${idUser}`);
  }

  // NOT SECURE, NOT IMPLEMENTED
  deleteUserAdmin(idUser: number, idAdmin: number) {
    return this.http.delete(`${url}/user/${idUser}/admin/${idAdmin}`);
  }

  checkUsername(username: string) {
    return this.http.get(`${url}/user/checkUsername/${username}`);
  }

  checkEmail(email: string) {
    return this.http.get(`${url}/user/checkEmail/${email}`);
  }
}
