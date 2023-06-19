import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { Theme, Subtheme, PostType } from '../types';
import { url } from './config';
import { Observable } from 'rxjs';

export interface ThemeNode {
  id: number;
  name: string;
  children?: SubthemeNode[];
}

export interface SubthemeNode {
  id: number;
  themeId: number;
  name: string;
}

@Injectable({
  providedIn: 'root'
})
export class ThemesService {
  constructor(private http: HttpClient) {}

  getThemes() {
    return this.http.get<any[]>(`${url}/themes`);
  }

  getSubthemes() {
    return this.http.get(`${url}/subthemes`);
  }

  getSubthemesByTheme(themeId: number) {
    return this.http.get<any[]>(`${url}/subthemes/${themeId}`)
  }

  postTheme(nTheme: Theme, idAdmin: number) {
    return this.http.post(`${url}/theme/admin/${idAdmin}`, nTheme)
  }

  postSubtheme(nSubtheme: Subtheme, idAdmin: number) {
    return this.http.post(`${url}/subtheme/admin/${idAdmin}`, nSubtheme);
  }

  editTheme(eTheme: Theme, idAdmin: number) {
    return this.http.put(`${url}/theme/admin/${idAdmin}`, eTheme)
  }

  editSubtheme(eSubtheme: Subtheme, idAdmin: number) {
    return this.http.put(`${url}/subtheme/admin/${idAdmin}`, eSubtheme)
  }

  deleteTheme(idTheme: number, idAdmin: number) {
    return this.http.delete(`${url}/theme/${idTheme}/admin/${idAdmin}`);
  }

  deleteSubtheme(idSubtheme: number, idAdmin: number) {
    return this.http.delete(`${url}/subtheme/${idSubtheme}/admin/${idAdmin}`);
  }
}
