import { Component, Inject } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { PostService } from 'src/app/services/post.service';
import { SharedDataService } from 'src/app/services/shared-data.service';
import { ThemesService } from 'src/app/services/themes.service';
import { User, Theme, Subtheme, PostType } from 'src/app/types';

@Component({
  selector: 'app-config-dialog',
  templateUrl: './config-dialog.component.html',
  styleUrls: ['./config-dialog.component.css']
})
export class ConfigDialogComponent {
  changes: boolean = false;
  user: User | null = null;
  themes: Array<Theme> = [];

  constructor(
    private sharedData: SharedDataService,
    private themesService: ThemesService,
    private postService: PostService,
    public DialogRef: MatDialogRef<ConfigDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) {}

  ngOnInit() {
    this.sharedData.data
    .subscribe((data: User | null) => {
      this.user = data;
    });
    this.themesService.getThemes()
    .subscribe((e: Array<Theme>) => {
      this.themes = e;
    });
  }

  newThemeForm = new FormGroup({
    name: new FormControl('', [Validators.required]),
  });

  newSubthemeForm = new FormGroup({
    name: new FormControl('', [Validators.required]),
    theme: new FormControl('', [Validators.required]),
  });

  newPostTypeForm = new FormGroup({
    type: new FormControl('', [Validators.required]),
  });

  newTheme() {
    if (this.newThemeForm.get('name') !== null && this.user !== null) {
      const theme = this.newThemeForm.get('name')!.value;
      const nTheme: Theme = {
        id: 0,
        name: theme!,
      };
      console.log("a");
      this.themesService.postTheme(nTheme, this.user!.id)
      .subscribe((e) => {
        this.changes = <boolean>e;
        if(e) {
          this.newThemeForm.patchValue({ name: '' });
          this.themesService.getThemes()
          .subscribe((e: Array<Theme>) => {
            this.themes = e;
            this.newThemeForm.patchValue({
              name: ''
            })
          });
        }
      });
    }
  }

  newSubtheme() {
    if (this.newSubthemeForm.get('name')!== null && this.newSubthemeForm.get('theme')!== null && this.user!== null) {
      const subthemeName = this.newSubthemeForm.get('name')!.value;
      const theme = parseInt(this.newSubthemeForm.get('theme')!.value!);
      const nSubtheme: Subtheme = {
        id: 0,
        themeId: theme!,
        name: subthemeName!,
      };
      this.themesService.postSubtheme(nSubtheme, this.user!.id)
      .subscribe((e) => {
        this.changes = <boolean>e;
        this.newSubthemeForm.patchValue({
          name: '',
          theme: '',
        });
      });
    }
  }

  newPostType() {
    if (this.newPostTypeForm.get('type')!== null && this.user!== null) {
      const postTypeName = this.newPostTypeForm.get('type')!.value;
      const nPostType: PostType = {
        id: 0,
        type: postTypeName!,
      };
      this.postService.postPostType(nPostType, this.user!.id)
      .subscribe((e) => {
        this.changes = <boolean>e;
        this.newPostTypeForm.patchValue({
          type: ''
        });
      });
    }
  }

  close() {
    this.DialogRef.close({ data: false });
  }
}
