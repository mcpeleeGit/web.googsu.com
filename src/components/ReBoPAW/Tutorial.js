import React, { Component } from 'react';

export class Tutorial extends Component {

    constructor(props) {
        super(props);
        this.state = { curTime: Tutorial.tick() };
      }
    

    static tick() {
        console.log('test');
        return (
          <div>
            <h1>Hello, world!</h1>
            <h2>It is {new Date().toLocaleTimeString()}.</h2>
          </div>
        );
    }


    componentDidMount() {
        setInterval( () => {
          this.setState({
            curTime : Tutorial.tick()
          })
        },1000)
      }

    render() {
       
        return (
            <div>
            <h1>Tutorial</h1>
            {this.state.curTime}
          </div>
        );
    }
}
