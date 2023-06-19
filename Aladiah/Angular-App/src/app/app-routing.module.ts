/* Angular imports */
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
/* App imports */
import { SubthemeComponent } from './main-page/subtheme/subtheme.component';
import { PostComponent } from './main-page/post/post.component';
import { AboutMeComponent } from './main-page/about-me/about-me.component';

const routes: Routes = [
  { path: 'subtheme/:id', component: SubthemeComponent, runGuardsAndResolvers: 'always'},
  { path: 'post/:id', component: PostComponent},
  { path: 'highlighted-posts', component: AboutMeComponent},
  { path: '', redirectTo: 'highlighted-posts', pathMatch: 'full' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {onSameUrlNavigation: 'reload'})],
  exports: [RouterModule]
})
export class AppRoutingModule { }
