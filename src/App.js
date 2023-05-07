import React from 'react';
import { RecoilRoot } from 'recoil';
import { Outlet } from "react-router-dom";
import {
  allJobsState,
  allLocationsState,
  allCategoriesState,
  allTypesState,
  allExperienceLevelsState
} from './recoil-state';

function App() {
  return (
    <RecoilRoot>
      <Outlet />
    </RecoilRoot>
  )
}

export default App;