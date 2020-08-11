import React, { Component } from 'react';
import AToDoService from './AToDoService';

export class AToDo extends Component {

    render(){
        return (
            <div>
                <h1>AToDo</h1>
                <AToDoService/>
            </div>
        );
    }
}