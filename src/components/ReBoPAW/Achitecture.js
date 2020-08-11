import React, { Component } from 'react';
import './Achitecture.css';

export class Achitecture extends Component {
    
    render() {
        const valCss = {
            fontSize: '50px'
        };
        const cont= "test contents";
        let isTrue = false;
        isTrue = true;
        
        return (
            <div>
                <h1>Achitecture</h1>
                {cont}
                {isTrue ? "isTrue" : "<br/>isTrue is false"}
                <div className="architecture" style={valCss}>{isTrue && "isTrue"}</div>
                {/*태그 밖*/}
                <div 
                    //태그 안 
                    /*태그 안*/
                    ></div>                
            </div>
        );
    }
}
