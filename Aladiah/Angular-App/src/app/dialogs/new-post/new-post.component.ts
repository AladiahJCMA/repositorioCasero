import { Component, Inject } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { PostService } from 'src/app/services/post.service';
import { SharedDataService } from 'src/app/services/shared-data.service';
import { ThemesService } from 'src/app/services/themes.service';
import { Post, PostType, Subtheme, Theme, User } from 'src/app/types';

@Component({
  selector: 'app-new-post',
  templateUrl: './new-post.component.html',
  styleUrls: ['./new-post.component.css']
})
export class NewPostComponent {
  subthemes: Array<Subtheme> = [];
  types: Array<PostType> = [];
  user: User | null = null;

  constructor(
    private sharedData: SharedDataService,
    private themesService: ThemesService,
    private postService: PostService,
    public DialogRef: MatDialogRef<NewPostComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) {}

  ngOnInit() {
    this.sharedData.data
    .subscribe((data: User | null) => {
      this.user = data;
      this.themesService.getSubthemes()
      .subscribe((e: Array<Subtheme> | any) => {
        this.subthemes = e;
        this.postService.getPostTypes()
        .subscribe((e: Array<PostType> | any) => {
          this.types = e;
          console.log(this.types);
        });
      });
    });
  }

  newPostForm = new FormGroup({
    type: new FormControl('', [Validators.required]),
    subtheme1: new FormControl('', [Validators.required]),
    subtheme2: new FormControl(''),
    subtheme3: new FormControl(''),
    name: new FormControl('', [Validators.required]),
    description: new FormControl('', [Validators.required]),
    originalCode: new FormControl(true),
    link: new FormControl(''),
    demo: new FormControl('')
  });

  newPost() {
    this.sharedData.data
    .subscribe((data: User | null) => {
      this.user = data;
    });
    if (!this.newPostForm.invalid && this.user !== null) {
      const nPost: Post = {
        id: 1,
        type: this.newPostForm.get('type')!.value!,
        creatorId: this.user.id,
        subtheme1: parseInt(this.newPostForm.get('subtheme1')!.value!),
        subtheme2: (this.newPostForm.get('subtheme2')!.value === '')? null : parseInt(this.newPostForm.get('subtheme2')!.value!),
        subtheme3: (this.newPostForm.get('subtheme3')!.value === '')? null : parseInt(this.newPostForm.get('subtheme3')!.value!),
        name: this.newPostForm.get('name')!.value!,
        description: this.newPostForm.get('description')!.value!,
        originalCode: this.newPostForm.get('originalCode')!.value!,
        link: this.newPostForm.get('link')!.value!,
        linkDemo: this.newPostForm.get('demo')!.value!,
        verifiedLink: false
      };
      this.postService.postPost(nPost)
      .subscribe((e: boolean | any) => {
        console.log(nPost);
        if(e) {
          this.DialogRef
          .close({ data: true });
        }
      })
    }
  }

  close() {
    this.DialogRef.close({ data: false });
  }
}
