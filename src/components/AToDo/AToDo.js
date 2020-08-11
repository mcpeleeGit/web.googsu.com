import React, { Component } from 'react';
import AToDoService from './AToDoService';

export class AToDo extends Component {

    constructor(props){
        super(props);
        this.state = {
            statetest : 'statetest'
        }
    }

    render(){
        return (
            <div>
                <h1>AToDo</h1>
                <AToDoService name="parameter name" anotherdefault={3}/>
                <p/>[{this.state.statetest}]
                <button onClick={()=>
                    this.setState({ statetest : this.state.statetest + 'statetest'})
                }>teststate</button>
            </div>
        );
    }
}