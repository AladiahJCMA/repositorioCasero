import { Component, OnInit } from '@angular/core';
import { ThemesService } from '../services/themes.service';
import { Theme, Subtheme } from '../types';
import { MatTreeNestedDataSource } from '@angular/material/tree';
import { NestedTreeControl } from '@angular/cdk/tree';
import { ThemeNode, SubthemeNode } from '../services/themes.service';


@Component({
  selector: 'app-nav-bar',
  templateUrl: './nav-bar.component.html',
  styleUrls: ['./nav-bar.component.css']
})
export class NavBarComponent implements OnInit {
  constructor(private themesService: ThemesService) {
  }

  dataSource = new MatTreeNestedDataSource<ThemeNode>();

  treeControl = new NestedTreeControl<ThemeNode>(node => node.children);



  themes: ThemeNode[] = [];

  ngOnInit() {
    this.themesService.getThemes().subscribe((themes) => {
      themes.forEach((theme, index) => {
        this.themes.push({
          id: theme.id,
          name: theme.name,
          children: [],
        });
        this.themesService
          .getSubthemesByTheme(theme.id)
          .subscribe((subthemes) => {
            subthemes.forEach((subtheme) => {
              this.themes[index].children?.push({
                id: subtheme.id,
                themeId: theme.id,
                name: subtheme.name,
              });
            });
            if (index === this.themes.length - 1) {  // I check to see if the foreach is on the last element (so i know all data is pushed)
              console.log('sub: ', this.themes);
              this.dataSource.data = this.themes;
            }
          });
      });
    });
  }

  hasNestedChild(index: number, node: ThemeNode) {
    let flag = false;
    if (node.children?.length !== undefined) {
      flag = node.children?.length > 0;
    }
    return flag;
  }

}