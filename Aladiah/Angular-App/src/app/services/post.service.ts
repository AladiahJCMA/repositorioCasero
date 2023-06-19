import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { Post, PostType } from '../types';
import { url } from './config';

@Injectable({
  providedIn: 'root'
})
export class PostService {
  constructor(private http: HttpClient) { }

  getPost(postId: number) {
    return this.http.get(`${url}/post/${postId}`);
  }

  getPostsBySubtheme(subthemeId: number) {
    return this.http.get(`${url}/posts/${subthemeId}`);
  }

  getPostsByScore() {
    return this.http.get(`${url}/posts/score`);
  }

  getPostTypes() {
    return this.http.get(`${url}/post_types`);
  }

  postPostType(nPostType: PostType, idAdmin: number) {
    return this.http.post(`${url}/post_types/admin/${idAdmin}`, nPostType);
  }

  postPost(nPost: Post) {
    return this.http.post(`${url}/post`, nPost);
  }

  editPost(ePost: Post, idUser: number) {
    return this.http.put(`${url}/post/user/${idUser}`, ePost);
  }

  editPostAdmin(ePost: Post, idAdmin: number) {
    return this.http.put(`${url}/post/admin/${idAdmin}`, ePost);
  }

  deletePost(idPost: number, idUser: number) {
    return this.http.delete(`${url}/post/${idPost}/user/${idUser}`);
  }

  deletePostAdmin(idPost: number, idAdmin: number) {
    return this.http.delete(`${url}/post/${idPost}/admin/${idAdmin}`);
  }

  votePost(idPost: number, idUser: number, vote: boolean) {
    return this.http.put(`${url}/post/${idPost}/user/${idUser}/vote`, vote);
  }
}
