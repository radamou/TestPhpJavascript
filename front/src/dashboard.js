import NavigationBar from "./components/navigation-bar/navigation-bar";
import Article from "./components/articles/article";
import Comment from "./components/comments/comment";
import Articles from "./components/articles/articles";
import Comments from "./components/comments/comments";

const navigationBar = new NavigationBar();
navigationBar.render(
    [
        {
            url: '/articles',
            title: 'articles'
        },
        {
            url: '/comments',
            title: 'comments'
        }
    ]
);

const url = window.location.pathname;

if (url === '/articles') {
    const data = [
        {
            title: "first comment 2",
            content: "comment descritpion 2"
        }
    ];
    const articles = new Articles()
    articles.render(data);
 }

 if (url === '/comments') {
     const data = [{
         title: "Ceci est un commentaire modifié 2",
         description: "ceci est la description d'un commentaire modifié 2",
         target: 2,
         notation: 1,
         uuid: "69e2f7fc-79c7-4096-8d68-c256037cf3e0"
     }];
     const comments = new Comments()
     comments.render(data);
 }

 if(url === '/articles/detail') {
     const data =
         {
             title: "first comment 2",
             content: "comment descritpion 2"
         }
     ;
     const article = new Article();
     article.render(data)
 }

if (url === '/comments/detail') {
    const data = {
        title: "Ceci est un commentaire modifié 2",
        description: "ceci est la description d'un commentaire modifié 2",
        target: 2,
        notation: 1,
        uuid: "69e2f7fc-79c7-4096-8d68-c256037cf3e0"
    };
    const comment = new Comment()
    comment.render(data);
}



