import React, { Component } from 'react';

export class WhatIs extends Component {

    render() {
        return (
            <div>
            <h1>What is ReBoPAW?</h1>
            <p>ReBoPAW = React + React BootStrap + PHP API + WordPress </p>
            <img src="/img/whatisrebopaw.jpg" alt="home" className="w-100 p-3"/>
            <ul>
              <li><a href="https://reactjs.org/">React</a> A JavaScript library for building user interfaces</li>
              <li><a href='https://react-bootstrap.github.io/'>React BootStrap</a> The most popular front-end framework. Rebuilt for React</li>
              <li><a href='https://www.php.net/'>PHP API</a> is a popular general-purpose scripting language that is especially suited to web. In addition, we have formed a RESTful API architecture that can operate DDD and MVC.</li>
              <li><a href='https://wordpress.com/read'>WordPress</a> Word Press is a great solution. However, many plug-ins become too slow to use. I refer to Word Press and offer a closed but customizable solution that works light and fast.</li>
            </ul>
            <p>Making this is just a personal hobby. I am planning to build it little by little with the following plan.:</p>
            <ul>
              <li><strong>Component Base Development</strong>. Each function consists entirely of folder units and is used as a closed plug-in. This eliminates compatibility issues. As soon as the software takes into account compatibility issues, complexity increases, slows, and errors increase. The person who took and used the components provided is responsible.</li>
              <li><strong>PHP RESTful API</strong>. The purpose of using PHP is one. Low cost of web server. There is no other reason. Many people have no money. There is no free shopping mall solution in the world. If you look closely, you will all incur costs. Just free. I aim for a solution that everyone brings and uses. In addition, RESTful API Architecture was formed. Reduced complexity and separated UI from logic and data. The user can replace the API server gradually when the conditions are met.</li>
              <li><strong>Simple</strong>. I was previously with an IT company that developed a trade O2O e-commerce platform and marketing solutions.  There is one thing I learned at that time. Simple usefulness is more effective in selling than attractiveness.</li>
              <li><strong>sole development</strong>. It's a free solution for people who don't have money. Naturally, it aims for a solution that can be built alone. Initial solution for one-person start-ups.</li>
              <li><strong>Slowly</strong>. It's a hobby. I'm going to make it slow and fun when I feel like it.</li>
            </ul>
          </div>
        );
    }

}
