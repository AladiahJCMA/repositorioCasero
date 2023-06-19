import { Component, Input } from '@angular/core';
import { ActivatedRoute, NavigationEnd, ParamMap, Router } from '@angular/router';
import { PostService } from 'src/app/services/post.service';
import { SharedDataService } from 'src/app/services/shared-data.service';
import { User } from 'src/app/types';

interface fullPosts {
  id: number,
	type: string,
  creatorId: number,
  subtheme1: number,
	subtheme1name: string,
  subtheme2: number,
	subtheme2name: string,
  subtheme3: number,
  subtheme3name: string,
	name: string,
	description: string,
  originalCode: boolean,
  link: string,
  linkDemo: string,
  linkVerified: boolean,
	score: number
}

@Component({
  selector: 'app-subtheme',
  templateUrl: './subtheme.component.html',
  styleUrls: ['./subtheme.component.css']
})
export class SubthemeComponent {
  navigationSubscription: any;

  constructor(
    private activatedRoute: ActivatedRoute,
    private postService: PostService,
    private sharedData: SharedDataService,
    private router: Router,
    ) {
      this.navigationSubscription = this.router.events
      .subscribe((event) => {
        if (event instanceof NavigationEnd) {
          this.initialiseInvites();
        }
      });
    }

  subthemeId: number | null = null;
  posts: Array<fullPosts> = [];
  user: User | null = null;
  
  ngOnInit() {
    this.posts = [];
    this.activatedRoute.paramMap
    .subscribe((params: ParamMap) => {
      if(params.get('id') !== null) {
        this.subthemeId = parseInt(params.get('id')!);
      }
    });

    this.postService.getPostsBySubtheme(this.subthemeId!)
    .subscribe((e: any) => {
      this.posts = e;
      console.log(this.posts);
    });

    this.sharedData.data.subscribe((data: User | null) => {
      this.user = data;
      console.log(this.user);
    });
  }

  initialiseInvites() {
    this.ngOnInit();
  }

  vote(postId: number, vote: boolean) {
    console.log("aaaaa");
    this.postService.votePost(postId, this.user!.id, vote)
    .subscribe((e) => console.log(e));
  }

}
