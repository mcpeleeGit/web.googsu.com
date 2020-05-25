import React, { Component } from 'react';

export class Home extends Component {
  static displayName = Home.name;

  render () {
    return (
      <div>
        <h1>Hello, world!</h1>
        <p>Welcome to my new single-page application, built with:</p>
        <img src="/img/home.jpg" alt="home" className="w-100 p-3"/>
        <ul>
          <li><a href="https://www.php.net/">PHP</a> Custom RESTful API</li>
          <li><a href='https://facebook.github.io/react/'>React</a> for client-side code</li>
          <li><a href='https://getbootstrap.com/'>Bootstrap</a> for layout and styling</li>
        </ul>
        <p>I will add the application with emphasis on the following contents:</p>
        <ul>
          <li><strong>Client-side navigation</strong>. For example, click <em>Counter</em> then <em>Back</em> to return here.</li>
          <li><strong>PHP RESTful API</strong>. The PHP development environment based on Linux can be deployed at the lowest cost. The goal of the <code>PHP RESTful API</code> is to make it possible to replace it with another system at any time with standard interfaces and access controls.</li>
          <li><strong>Efficient production builds</strong>. In production mode, development-time features are disabled, and your <code>dotnet publish</code> configuration produces minified, efficiently bundled JavaScript files.</li>
        </ul>
        <p>The <code>ClientApp</code> subdirectory is a standard React application based on the <code>create-react-app</code> template. If you open a command prompt in that directory, you can run <code>npm</code> commands such as <code>npm test</code> or <code>npm install</code>.</p>
      </div>
    );
  }
}
